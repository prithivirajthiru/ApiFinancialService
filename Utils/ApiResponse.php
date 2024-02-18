<?php
namespace App\Utils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Doctrine\ORM\EntityManagerInterface;
class ApiResponse extends Response{
    public function __construct($content = "", int $status = 200, array $headers = [],$type='json', $msg='',$ignoreType= [])
    {
        // $encoders = [ new JsonEncoder()];
        // $objNormaliser=new ObjectNormalizer();
        // // $objNormaliser->setCircularReferenceLimit(1);
        // // $objNormaliser->setCircularReferenceHandler(function ($object) {
        // // return null;
        // // });
        // $objNormaliser=new ObjectNormalizer(null,null,null,null,null,null,array(ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER=>function ($object) {
        //     return $object;
        // }));
        // $normalizers = [ $objNormaliser,new DateTimeNormalizer()];
        // $serializer = new Serializer($normalizers ,$encoders);
        // // $check = $serializer->serialize($content, 'json');
        // // $data = $this->json($content, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
        // $jsonContent = json_decode(
        //     $serializer->serialize(["data"=>$content,"msg"=>$msg,"status"=>$status], $type,[AbstractNormalizer::IGNORED_ATTRIBUTES => ['commandes']]),
        //     JSON_OBJECT_AS_ARRAY
        // );
        // // $jsonContent = ;
        // $this->headers = new ResponseHeaderBag($headers);
        // $this->setContent($jsonContent);
        // $this->setStatusCode(200);
        // $this->setProtocolVersion('1.0');

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($content, $type, $msg) {
                return $content->getId();
            },
        ];
        $ObjectNormalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        
        // $serializer = new Serializer([$normalizer], [$encoder]);
        $normalizer = [ $ObjectNormalizer,new DateTimeNormalizer()];
            $serializer = new Serializer($normalizer, [$encoder]);
        //      $jsonContent = json_decode(
        //     $serializer->serialize(["data"=>$content,"msg"=>$msg,"status"=>$status], $type,[AbstractNormalizer::IGNORED_ATTRIBUTES => ['commandes']]),
        //     JSON_OBJECT_AS_ARRAY
        // );
        // $jsonContent = json_decode(
        //     $serializer->serialize(["data"=>$content,"msg"=>$msg,"status"=>$status], $type,[AbstractNormalizer::IGNORED_ATTRIBUTES => ['commandes']]),
        //     JSON_OBJECT_AS_ARRAY
        // );
        $jsonContent = $serializer->serialize(["data"=>$content,"msg"=>$msg,"status"=>$status], $type,['ignored_attributes' => $ignoreType]);

        // // $jsonContent = ;
        $this->headers = new ResponseHeaderBag($headers);
         $this->setContent($jsonContent);
         $this->setStatusCode(200);
        $this->setProtocolVersion('1.0');
            // $manager->persist($content);
            // $manager->flush();
            // $result = $serializer->normalize(
            //     [
            //         'data'=>$content,
            //         'code' => $status,
            //         "msg"=>$msg,
            //     ],
            //     null,
            //     [AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]
            // );
            
            // $jsonContent = $serializer->serialize(
            //     $result,
            //     'json'
            // );
            // return new Response($jsonContent);
    }
}