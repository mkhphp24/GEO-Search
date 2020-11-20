<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Entity\PostalCodeLocation;
use App\Services\PostalCodeLocationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\PartnerService;
use App\Services\GeoJsonService;
use App\Validation\ValidationData;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home" , methods={"GET","HEAD"} )
     */
    public function index(Request $request)
    {
        $objectServiceAutor = new PartnerService( $this->getDoctrine()->getManager(), Partner::class);

        return $this->render('home.html.twig');
    }


    /**
     * @Route("/api/cordinate/", name="api_cordinate" , methods={"POST"} )
     */
    public function getCordinate(Request $request)
    {

       try {

           $lat =$request->request->get('form-distance-lat');
           $lng=$request->request->get('form-distance-lng');
           $distance=($request->request->get('form-distance-km')*1000);
           $datavalidate=new ValidationData( $request->request->all() );
           $validationData=$datavalidate->checkCordinate();

           if(empty($validationData['Error'])) {

               $objectPartnerService = new PartnerService( $this->getDoctrine()->getManager(), Partner::class);
               $points=$objectPartnerService->findDistance( $lat , $lng , $distance);
               $geoJsonService=new GeoJsonService($points);

               return new Response($geoJsonService->makePoint($lng,$lat), Response::HTTP_OK, ['content-type' => 'application/json']);
           } else {
               return new Response(json_encode($validationData['Error']), Response::HTTP_BAD_REQUEST, ['content-type' => 'application/json']);
           }


           }catch (\Exception $e) {

               return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST, ['content-type' => 'application/json']);

           }

    }

    /**
     * @Route("/api/search/postcod/{page}/", name="api_postcode" , methods={"GET"} )
     */
    public function getPostCode(Request $request,$page)
    {

        try {
            $postCode=$request->query->get('q')['term'];
            $datavalidate=new ValidationData( ['post-code'=>$postCode] );
            $validationData=$datavalidate->checkPostCode();

            if(empty($validationData['Error'])) {

                $objectPostalCodeLocation = new PostalCodeLocationService( $this->getDoctrine()->getManager(), PostalCodeLocation::class);
                $result=$objectPostalCodeLocation->PostalCodeLocationSearchfield('postalCode', $postCode,$page);
                $result_array=["total_count"=>count($result), "incomplete_results"=>false,"items"=>$result];

                return new Response( json_encode($result_array), Response::HTTP_OK, ['content-type' => 'application/json']);

            }  else {

                return new Response(json_encode($validationData['Error'],true), Response::HTTP_BAD_REQUEST, ['content-type' => 'application/json']);
            }

            } catch (\Exception $e) {

                    return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST, ['content-type' => 'application/json']);

            }

    }

}
