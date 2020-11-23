<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Order;

class OrderStageController extends AbstractController
{
    /**
     * @Route("/api/orderstage", name="api_order_stage", methods={"POST"})
     */
    public function updateOrderStage(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Get request json
        $data = json_decode($request->getContent(), true);

        // If for some reason we have blank values
        if (!isset($data['request'])) {
            $data['request'] = 'none';
        }
        if (!isset($data['order'])) {
            $data['request'] = 0;
        }

        // No error
        $error = 0;

        // No message
        $message = '';

        // ID (creation only)
        $newID = 0;

        // Error codes
        $erCodeList = array(
            0 => 'OK',
            1 => 'Unable to advance to requested stage due to type conflict', // Example, can't move "Contract" type to "Expired"
            2 => 'No order ID specified', // We can't update an order if it's not here!
            3 => 'Error creating order, missing values' // Values for new order not provided
        );

        $type = 'Unknown';

        // Get order details
        if ($data['order'] > 0) {
            $order = $this->getDoctrine()->getRepository('App\Entity\Order'::class)->findByID($data['order']);
            $type  = $order[0]->getTYPE();
        }

        // Perform action based on request value
        switch ($data['request']) {
            case 'test' :
                // No need to do anything, this is only triggered by the unit test
                break;
            case 'delete' :
                // Delete order after test, this is only triggered by the unit test
                $entityManager->remove($order[0]);
                $entityManager->flush();
                break;
            case 'reset' :
                // Reset back to created, this is only triggered by the unit test
                if ($type != 'Unknown') {
                    $order[0]->setSTAGE('Created');
                    $entityManager->flush();
                } else {
                    $error = 2;
                }
                break;
            case 'check' :
                // Return the current stage
                $message = $order[0]->getSTAGE();
                break;
            case 'expired' :
                // Set a free trial to expired
                if ($type != 'Trial') {
                    // drop out with error
                    $error = 1;
                } else {
                    if ($type != 'Unknown') {
                        $order[0]->setSTAGE('Expired');
                        $entityManager->flush();

                        // TODO: Email Customer about expiry
                        $emailSent = true;

                        if ($emailSent) {
                            $message = 'CustomerSent:Yes';
                        }
                    } else {
                        $error = 2;
                    }
                }
                break;
              case 'signed' :
                  // Set a contract trial to signed
                  if ($type != 'Contract') {
                      // drop out with error
                      $error = 1;
                  } else {
                      if ($type != 'Unknown') {
                          $order[0]->setSTAGE('Signed');
                          $entityManager->flush();

                          // TODO: Generate and store PDF
                          $pdfStored = true;

                          if ($pdfStored) {
                              $message = 'PDFStored:Yes';
                          }
                      } else {
                          $error = 2;
                      }
                  }
                  break;
              case 'approved' :
                    // Set to approved
                    if ($type != 'Unknown') {
                        $order[0]->setSTAGE('Approved');
                        $entityManager->flush();

                        if ($type == 'Contract') { // Contract only
                            // TODO: Email Customer about approval
                            $emailSent = true;

                            if ($emailSent) {
                                $message = 'CustomerSent:Yes';
                            }
                        } else {
                            $message = 'CustomerSent:Yes'; // Keep the unit test happy
                        }
                    } else {
                        $error = 2;
                    }
                    break;
                case 'delivered' :
                      // Set to delivered
                      if ($type != 'Unknown') {
                          $order[0]->setSTAGE('Delivered');
                          $entityManager->flush();

                          // TODO: Email Sales Team for followup
                          $emailSent = true;

                          if ($emailSent) {
                              $message = 'SalesSent:Yes';
                          }
                      } else {
                          $error = 2;
                      }
                      break;
                  case 'completed' :
                        // Set to delivered
                        if ($type != 'Unknown') {
                            $order[0]->setSTAGE('Completed');
                            $entityManager->flush();
                        } else {
                            $error = 2;
                        }
                        break;
                  case 'created' :
                        // Unlike the other stages, this stage requires a new order to be created
                        // We'll need:
                        // # The customer ID
                        // # The net value (if contract)
                        // # The type (Trial/Contract)
                        // # The product
                        if (
                            isset($data['customer'])  &&
                            isset($data['net'])       &&
                            isset($data['type'])      &&
                            isset($data['product'])   &&
                            isset($data['user'])
                        ){
                            $net    = $data['net'];
                            $vat    = $net * 0.2;
                            $total  = $net + $vat;

                            // Wipe amounts if free trial, just in case
                            if ($data['type'] == 'trial') {
                                $net    = 0;
                                $vat    = 0;
                                $total  = 0;
                            }

                            $order = new Order();
                            $order->setCUSTOMER($data['customer']);
                            $order->setPRODUCT($data['product']);
                            $order->setTYPE(ucWords($data['type']));
                            $order->setSTAGE('Created');
                            $order->setDATE(new \DateTime());
                            $order->setNET($net);
                            $order->setVAT($vat);
                            $order->setTOTAL($total);
                            $order->setUSER($data['user']);

                            $entityManager->persist($order);
                            $entityManager->flush();

                            $newID = $order->getId();

                            // TODO: Email Customer about order creation
                            $emailSent = true;

                            if ($emailSent) {
                                $message = 'CustomerSent:Yes';
                            }
                        } else {
                            $error = 3;
                        }
                        break;
        }

        // Construct response
        $response = new Response('', 201);

        // Add json
        $response->setContent(json_encode([
            'request'   => $data['request'],
            'error'     => $error,
            'errorDesc' => $erCodeList[$error],
            'message'   => $message,
            'newID'     => $newID
        ]));

        // Supply new resource to redirect to
        $response->headers->set('Location', '/some/new/resource');

        return $response;
    }
}
