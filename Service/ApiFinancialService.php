<?php

namespace App\Service;


use App\Entity\RefAttachmentType;
use App\Entity\RefDocument;
use App\Entity\DataProfile;
use App\Entity\DataCollectionChart;
use App\Entity\DataPhoto;

use App\Entity\RefCollectionChart;

use App\Entity\RefDaySlot;
use App\Entity\IdGenerator;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ApiFinancialService
{
    protected  $EM;

    public function __construct(EntityManagerInterface $EM)
    {
        $this->EM = $EM;
    }
    public function _addDataProfile($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataProfile::class, 'json');
        $AutoId = $this->IdGenerator("profile");
        $daySlotId =   $data->getDaySlotId();
        $RefRefDaySlot = $this->EM->getRepository(RefDaySlot::class);
        $objRefDaySlot = $RefRefDaySlot->findOneBy(['id' => $daySlotId]);

        if ($objRefDaySlot == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }

        $profile = new DataProfile;
        $profile->setName($data->getName());
        $profile->setUniqueCodeNo($AutoId);
        $profile->setGuardianName($data->getGuardianName());
        $profile->setAge($data->getAge());
        $profile->setGender($data->getGender());
        $profile->setStreetName($data->getStreetName());
        $profile->setCityName($data->getCityName());
        $profile->setDistrictName($data->getDistrictName());
        $profile->setPincode($data->getPincode());
        $profile->setIncome($data->getIncome());
        $profile->setMaritalStatus($data->getMaritalStatus());
        $profile->setDateOfRegistration(new \DateTime());
        $profile->setIsActive(true);
        $profile->setDaySlot($objRefDaySlot);
        $profile->setGivenAmount($data->getGivenAmount());
        $profile->setPhoneNumber($data->getPhoneNumber());
        $profile->setSecondaryNumber($data->getSecondaryNumber());
        $this->EM->persist($profile);
        $this->EM->flush();

        return ["ok", $profile];
    }
    public function _addDataProfileV1($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataProfile::class, 'json');
        $AutoId = $this->IdGenerator("profile");
        $daySlotId =   $data->getDaySlotId();
        $weekNumber =   $data->getWeekNumber();
        $RefRefDaySlot = $this->EM->getRepository(RefDaySlot::class);
        $objRefDaySlot = $RefRefDaySlot->findOneBy(['id' => $daySlotId]);
       
        if ($objRefDaySlot == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }

        $profile = new DataProfile;
        $profile->setName($data->getName());
        $profile->setUniqueCodeNo($AutoId);
        $profile->setGuardianName($data->getGuardianName());
        $profile->setAge($data->getAge());
        $profile->setGender($data->getGender());
        $profile->setStreetName($data->getStreetName());
        $profile->setCityName($data->getCityName());
        $profile->setDistrictName($data->getDistrictName());
        $profile->setPincode($data->getPincode());
        $profile->setIncome($data->getIncome());
        $profile->setMaritalStatus($data->getMaritalStatus());
        $profile->setDateOfRegistration(new \DateTime());
        $profile->setIsActive(true);
        $profile->setDaySlot($objRefDaySlot);
        $profile->setGivenAmount($data->getGivenAmount());
        $profile->setPhoneNumber($data->getPhoneNumber());
       $day= $objRefDaySlot->getName();
        $this->EM->persist($profile);
        $this->EM->flush();

        for($i=1;$i<=$weekNumber;$i++){
            
            // $prev_date = time();

            // $prev_date = date('Y-m-d', $prev_date);
            
          

            // $prev_date = time();
           
           
                $DataCollectionChart = new DataCollectionChart;
           
           
                if($i==1){
                    $prev_date= strtotime( $day);
                    }
                    $prev_date = date('Y-m-d', $prev_date);

           $DataCollectionChart->setDateOfDueGiven(new \DateTime( $prev_date ));
           
           $DataCollectionChart->setProfile($profile);
           $DataCollectionChart->setWeekNumber($i);
           $DataCollectionChart->setActualAmount(0); 
           $DataCollectionChart->setDueAmount(0); 
           $DataCollectionChart->setPenaltyAmount(0);

           

           $prev_date= strtotime( $prev_date.' + 7 day' );
           
           $this->EM->persist($DataCollectionChart);
           $this->EM->flush();      
           
           
           
        }
       
        
           

       
        return ["ok", $profile];
    }
    public function _addDataProfileV2($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataProfile::class, 'json');
        $AutoId = $this->IdGenerator("profile");
        $daySlotId =   $data->getDaySlotId();
        $weekNumber =   $data->getWeekNumber();
        $RefRefDaySlot = $this->EM->getRepository(RefDaySlot::class);
        $objRefDaySlot = $RefRefDaySlot->findOneBy(['id' => $daySlotId]);
       
        
        if ($objRefDaySlot == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-=~!@#$%^&*()_+,./<>?;:[]{}\|';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $pass1  =implode($pass);
        $profile = new DataProfile;
        $profile->setName($data->getName());
        $profile->setUniqueCodeNo($AutoId);
        $profile->setGuardianName($data->getGuardianName());
        $profile->setAge($data->getAge());
        $profile->setGender($data->getGender());
        $profile->setStreetName($data->getStreetName());
        $profile->setCityName($data->getCityName());
        $profile->setDistrictName($data->getDistrictName());
        $profile->setPincode($data->getPincode());
        $profile->setIncome($data->getIncome());
        $profile->setMaritalStatus($data->getMaritalStatus());
        $profile->setDateOfRegistration(new \DateTime());
        $profile->setIsActive(true);
        $profile->setDaySlot($objRefDaySlot);
        $profile->setGivenAmount($data->getGivenAmount());
        $profile->setPhoneNumber($data->getPhoneNumber());
        $profile->setSecondaryNumber($data->getSecondaryNumber());
        $profile->setRole("user");
        $profile->setPassword($pass1);
       $day= $objRefDaySlot->getName();
        $this->EM->persist($profile);
        $this->EM->flush();

        for($i=1;$i<=$weekNumber;$i++){
            
                $DataCollectionChart = new DataCollectionChart;
           
           
        //         if($i==1){
        //             $prev_date= strtotime( $day);
        //             }
        //             $prev_date = date('Y-m-d', $prev_date);

        //    $DataCollectionChart->setDateOfDueGiven(new \DateTime( $prev_date ));
           
           $DataCollectionChart->setProfile($profile);
           $DataCollectionChart->setWeekNumber($i);
           $DataCollectionChart->setActualAmount(0); 
           $DataCollectionChart->setDueAmount(0);
           $DataCollectionChart->setPenaltyAmount(0);

           

         //  $prev_date= strtotime( $prev_date.' + 7 day' );
           
           $this->EM->persist($DataCollectionChart);
           $this->EM->flush();      
           
           
           
        }
       
    
        return ["ok", $profile];
    }
    public function _userLogin($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataProfile::class, 'json');

        $Username = $data->getUserName();
        $Password = $data->getPassword();

        $query = "SELECT * FROM data_profile 
       where phone_number = '$Username' ";
        $connection = $this->EM->getconnection();
        $objDataProfile = $connection->executeQuery($query)->fetch();
        if ($objDataProfile != null) {
            $Userid = $objDataProfile["id"];
            $query = "SELECT * FROM data_profile 
      where id='$Userid' and password =  '$Password' ";
            $connection = $this->EM->getconnection();
            $objauthentication = $connection->executeQuery($query)->fetch();
          
          
            if ($objauthentication) {
                $role =   $objauthentication['role'];
                $carrepo = $this->EM->getRepository(DataProfile::class);

                $DataProfile = $carrepo->findOneBy(['id' => $Userid]);
                // if(  $role =='admin'){
                    
                  
                // }
                // else{
                //     $DataProfile = $carrepo->findBy(['profile' => $Userid]);
                   
                // }
               
                if ($DataProfile) {

                    return ["ok", $DataProfile];
                }
                else {
                    return  ["error", "Invalid "];
                }

            } else {
                return  ["error", "Invalid password"];
            }
        } else {
            return  ["error", "Invalid Username"];
        }
    }

    public function _updateDataProfile($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataProfile::class, 'json');

        $daySlotId =   $data->getDaySlotId();
        $RefRefDaySlot = $this->EM->getRepository(RefDaySlot::class);
        $objRefDaySlot = $RefRefDaySlot->findOneBy(['id' => $daySlotId]);

        if ($objRefDaySlot == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }
        $Id =   $data->getId();

        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);

        if ($objDataProfile == null) {
            return    ["error", "DataProfile Id is Invalid"];
        }

        $objDataProfile->setName($data->getName());
        $objDataProfile->setGuardianName($data->getGuardianName());
        $objDataProfile->setAge($data->getAge());
        $objDataProfile->setGender($data->getGender());
        $objDataProfile->setStreetName($data->getStreetName());
        $objDataProfile->setCityName($data->getCityName());
        $objDataProfile->setDistrictName($data->getDistrictName());
        $objDataProfile->setPincode($data->getPincode());
        $objDataProfile->setIncome($data->getIncome());
        $objDataProfile->setMaritalStatus($data->getMaritalStatus());
        $objDataProfile->setDateOfRegistration(new \DateTime());
        $objDataProfile->setIsActive(true);
        $objDataProfile->setDaySlot($objRefDaySlot);
        $objDataProfile->setGivenAmount($data->getGivenAmount());
        $objDataProfile->setPhoneNumber($data->getPhoneNumber());
        $objDataProfile->setPassword($data->getPassword());
        $objDataProfile->setSecondaryNumber($data->getSecondaryNumber());
        $this->EM->persist($objDataProfile);
        $this->EM->flush();

        return ["ok", $objDataProfile];
    }
    public function IdGenerator($code)
    {
        $Idgeneratorrepo = $this->EM->getRepository(IdGenerator::class);
        $generate = $Idgeneratorrepo->findOneBy(['code' => $code]);

        $generate->setvalue($generate->getvalue() + 1);
        $this->EM->persist($generate);
        $this->EM->flush();
        return sprintf("%s%0" . $generate->getLength() . "d%s", $generate->getPrefix(), $generate->getValue(), $generate->getSuffix());
    }



    public function _updateStatusChangeEnable($Id)
    {


        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "DataProfile Id is Invalid";
        }

        $objDataProfile->setIsActive(true);
        $this->EM->persist($objDataProfile);
        $this->EM->flush();
        return $objDataProfile;
    }


    public function _updateStatusChangeDisable($Id)
    {

        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "DataProfile Id is Invalid";
        }

        $objDataProfile->setIsActive(false);
        $this->EM->persist($objDataProfile);
        $this->EM->flush();
        return $objDataProfile;
    }

    public function _getSingle($Id)
    {

        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "DataProfile Id is Invalid";
        }

        return $objDataProfile;
    }
    public function _getDataProfileStatusChangeEnable()
    {

        $RefDataCollectionChart = $this->EM->getRepository(DataProfile::class);
        $objDataCollectionChart = $RefDataCollectionChart->findBy(['isActive' => 1]);

        if ($objDataCollectionChart == null) {
            return    ["error", "profile Id is Invalid"];
        }
        return ["ok", $objDataCollectionChart];
    }
    public function _getSingleDataProfile($Id)
    {

        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "DataProfile Id is Invalid";
        }
        $resposityDataPhotos = $this->EM->getRepository(DataPhoto::class);
        $DataPhotos = $resposityDataPhotos->findBy(['profile' => $Id]);
        if ($DataPhotos == null) {
            return "DataProfile Id is Invalid";
        }


        $objDataProfile->setPhotos($DataPhotos);



        return $objDataProfile;
    }
    public function _getSingleDataProfile1($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataProfile::class, 'json');
        $id = $data->getId();
        $name = $data->getName();
        $Income = $data->getIncome();
        $guardianName =   $data->getGuardianName();
        $streetName = $data->getStreetName();
        $age = $data->getAge();
        $gender = $data->getGender();
        $cityName = $data->getCityName();
        $districtName = $data->getDistrictName();
        $pincode = $data->getPincode();
        $maritalStatus = $data->getMaritalStatus();
        $givenAmount = $data->getGivenAmount();
        $phoneNumber = $data->getPhoneNumber();
        $daySlotId = $data->getDaySlotId();
        $isActive = $data->isIsActive();
        $fromDate = $data->getFromdate();
        $uniqueCodeNo = $data->getUniqueCodeNo();
        $DataProfilearray = [];

        if(   $id||    $name || $Income ||  $guardianName ||    $streetName || $cityName ||  $districtName  ||    $fromDate || $givenAmount ||  $phoneNumber || $age ||  $gender  ||    $uniqueCodeNo || $pincode ||  $maritalStatus   ){
        $query1 = "   SELECT * FROM `data_profile` WHERE    ";                           
        if ($id) {
            $query1 = $query1 . "   id ='$id' AND";
        }

        if ($name) {
            $query1 = $query1 . "   name   = '$name '  AND";
        }

        if ($Income) {
            $query1 = $query1 . "  income  = '$Income '  AND";
        }
        if ($guardianName) {
            $query1 = $query1 . "  guardian_name  = '$guardianName '  AND";
        }
        if ($streetName) {
            $query1 = $query1 . "  street_name  = '$streetName '  AND";
        }

        if ($cityName) {
            $query1 = $query1 . "  city_name  = '$cityName '  AND";
        }
        if ($districtName) {
            $query1 = $query1 . "  district_name  = '$districtName '  AND";
        }
        if ($fromDate) {
            $query1 = $query1 . "  date_of_registration  =  date( '  $fromDate ')  AND";
        }
        if ($givenAmount) {
            $query1 = $query1 . "  given_amount  = '$givenAmount '  AND";
        }
        if ($phoneNumber) {
            $query1 = $query1 . "  phone_number  = '$phoneNumber '  AND";
        }
        if ($age) {
            $query1 = $query1 . "  age  = '$age '  AND";
        }
        if ($gender) {
            $query1 = $query1 . "  gender  = '$gender '  AND";
        }

        if ($maritalStatus) {
            $query1 = $query1 . "  marital_status  = '$maritalStatus '  AND";
        }
        if ($daySlotId) {
            $query1 = $query1 . "  day_slot_id  = '$daySlotId '  AND";
        }
        if ($pincode) {
            $query1 = $query1 . "  pincode  = '$pincode '  AND";
        }
        if ($uniqueCodeNo) {
            $query1 = $query1 . "  unique_code_no  = '$uniqueCodeNo '  AND";
        }

        if ($isActive) {
            $query1 = $query1 . "  is_active=  $isActive AND";
        }
        if (substr($query1, -3) == "AND") {
            $query1 =  substr($query1, 0, -3);
        }
        //      return    $query ; OR `is_active`=  $isActive
        $connection = $this->EM->getconnection();
        $objData = $connection->executeQuery($query1)->fetchAll();
        if ($objData) {
            foreach ($objData as $image) {
                $Id = $image["id"];
                $resposityDataPhotos = $this->EM->getRepository(DataProfile::class);
                $DataProfile = $resposityDataPhotos->findOneBy(['id' => $Id]);
                if ($DataProfile) {

                    $DataProfilearray[] =  $DataProfile;
                }

            }
        }
    }
        if($DataProfilearray == null){
            $resposityDataPhotos = $this->EM->getRepository(DataProfile::class);
            $objRefCategory = $resposityDataPhotos->findAll();
            
            $DataProfilearray =  $objRefCategory;
          }
           return $DataProfilearray;
    }
    public function _getAllProfile()
    {

        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findAll();
        if ($objDataProfile == null) {
            return "DataProfile Id is Invalid";
        }

        foreach ($objDataProfile as $image) {
            $Id =   $image->getId();
            $resposityDataPhotos = $this->EM->getRepository(DataPhoto::class);
            $DataPhotos = $resposityDataPhotos->findBy(['profile' => $Id]);
            if ($DataPhotos) {
                $image->setPhotos($DataPhotos);
            }
        }

        return $objDataProfile;
    }
    // public function _getProfile()
    // {

    //     $RefDataProfile = $this->EM->getRepository(DataProfile::class);
    //     $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
    //     if ($objDataProfile == null) {
    //         return "DataProfile Id is Invalid";
    //     }

    //     foreach ($objDataProfile as $image1) {
    //         $Id =   $image1->getId();
    //         $resposityDataPhotos = $this->EM->getRepository(DataPhoto::class);
    //         $DataPhotos = $resposityDataPhotos->findBy(['profile' => $Id]);
    //     if ($DataPhotos) {
    //         foreach ($DataPhotos as $image) {   
                  
    //                 $Id1 =   $image->getAttachmentType()->getId();
    //                 $RefAttachmentTyperepo = $this->EM->getRepository(RefAttachmentType::class);
    //                 $objRefAttachmentType = $RefAttachmentTyperepo->findOneBy(['id' => $Id1]);
    //                $Name= $objRefAttachmentType ->getName();
    //                $Name=  ucfirst( $Name);
    //           $image= array ($image);
    //                 $Name1 = "set".$Name."Photos";
    //                 $image1->$Name1($image);
    //         }
    //     }
    // }
    //     return $objDataProfile;
    // }
    // public function _getProfile15($Id )
    // {

    //     $RefDataProfile = $this->EM->getRepository(DataProfile::class);
    //     $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
    //     if ($objDataProfile == null) {
    //         return "DataProfile Id is Invalid";
    //     }

    
        
    //         $resposityDataPhotos = $this->EM->getRepository(DataPhoto::class);
    //         $DataPhotos = $resposityDataPhotos->findBy(['profile' => $Id]);
    //     if ($DataPhotos) {
    //         foreach ($DataPhotos as $image) {   
                  
    //                 $Id1 =   $image->getAttachmentType()->getId();
    //                 $RefAttachmentTyperepo = $this->EM->getRepository(RefAttachmentType::class);
    //                 $objRefAttachmentType = $RefAttachmentTyperepo->findOneBy(['id' => $Id1]);
    //                $Name= $objRefAttachmentType ->getName();
    //                $Name=  ucfirst( $Name);
    //           $image= array ($image);
    //                 $Name1 = "set".$Name."Photos";
    //                 $objDataProfile->$Name1(array_push($image));
    //         }
        
    // }
    //     return $objDataProfile;
    // }
    public function _getProfile1($Id )
    {

        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "DataProfile Id is Invalid";
        }
            $RefAttachmentTyperepo = $this->EM->getRepository(RefAttachmentType::class);
            $objRefAttachmentType = $RefAttachmentTyperepo->findAll();

        if ($objRefAttachmentType) {
            foreach ($objRefAttachmentType as $image) {   
                  
                    $Id1 =   $image->getId();
                    $Name= $image ->getName();
                    $resposityDataPhotos = $this->EM->getRepository(DataPhoto::class);
                    $DataPhotos = $resposityDataPhotos->findBy(['profile' => $Id,'attachmentType'=>  $Id1  ]);

                    
                  
                   $Name=  ucfirst( $Name);
             
                    $Name1 = "set".$Name."Photos";
                    $objDataProfile->$Name1($DataPhotos);
            }
        
    }
        return $objDataProfile;
    }
    public function _DeleteOfDataProfile($Id)
    {

        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "DataProfile Id is Invalid";
        }
        $this->EM->remove($objDataProfile);
        $this->EM->flush();

        return "ok";
    }
    public function _fileUploadOfRefCategory($request) 
    {

        $Id = $request->get('profileId');
        $attachmentTypeId = $request->get('attachmentTypeId');
        $imagefiles = $request->files->get('files');
        $DataPhotoarr=[];
        foreach ($imagefiles as $image) {
            $RefDataProfile = $this->EM->getRepository(DataProfile::class);
            $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
            if ($objDataProfile == null) {

                return "Invalid";
            }

            $RefRefAttachmentType = $this->EM->getRepository(RefAttachmentType::class);
            $objRefAttachmentType = $RefRefAttachmentType->findOneBy(['id' => $attachmentTypeId]);
            if ($objRefAttachmentType == null) {
                return "Invalid";
            }

            $originalFilename = $image->getClientOriginalName();

            $UploadDirectory = "photo/$Id/$attachmentTypeId/";
            $image->move($UploadDirectory, $originalFilename);
            $DataPhoto = new DataPhoto;
            $DataPhoto->setPath($UploadDirectory . $originalFilename);
            $DataPhoto->setProfile($objDataProfile);
            $DataPhoto->setAttachmentType($objRefAttachmentType);
            $this->EM->persist($DataPhoto);
            $this->EM->flush();
            $DataPhotoarr[]=$DataPhoto;
        }
        return $DataPhotoarr;
    }
    public function _getfileUploadOfRefCategory($RefAttachmentType_id)
    {
        
        $RefAttachmentTyperepo = $this->EM->getRepository(DataPhoto::class);
        $objRefAttachmentType = $RefAttachmentTyperepo->findOneBy(['attachmentType' => $RefAttachmentType_id]);
        if ($objRefAttachmentType == null) {
            return "Invalid attachmentId";
        }
        return $objRefAttachmentType;
    }
    public function _filedownloadDataProduct($id)
    {
        $resposityDataPhotos = $this->EM->getRepository(DataPhoto::class);
        $DataPhotos = $resposityDataPhotos->findBy(['id' => $id]);
        foreach ($DataPhotos as $DataPhotos1) {
        $filepath =  $DataPhotos1->getPath();
        $response = new BinaryFileResponse($filepath);
        
        }
        return $response;
    }
    public function _DeleteOffile($Id)
    {

        $RefDataProfile = $this->EM->getRepository(DataPhoto::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "file Id is Invalid";
        }
        $this->EM->remove($objDataProfile);
        $this->EM->flush();

        return "ok";
    }
    public function _getfileStatusChangeEnable()
    {

        $RefDataCollectionChart = $this->EM->getRepository(DataPhoto::class);
        $objDataCollectionChart = $RefDataCollectionChart->findBy(['isActive' => 1]);

        if ($objDataCollectionChart == null) {
            return    ["error", "profile Id is Invalid"];
        }
        return ["ok", $objDataCollectionChart];
    }
    public function _addDataCollectionChart($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataCollectionChart::class, 'json');

        $profileId =   $data->getProfileId();
        $collectionId =   $data->getCollectionId();

        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $profileId]);
        if ($objDataProfile == null) {
            return "DataProfile Id is Invalid";
        }


        $RefRefCollectionChart = $this->EM->getRepository(RefCollectionChart::class);
        $objRefCollectionChart = $RefRefCollectionChart->findOneBy(['id' => $collectionId]);

        if ($objRefCollectionChart == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }

        $DataCollectionChart = new DataCollectionChart;
        $DataCollectionChart->setDueAmount($data->getDueAmount());
        $DataCollectionChart->setDateOfDueGiven(new \DateTime());
        $DataCollectionChart->setPenaltyAmount($data->getPenaltyAmount());
        $DataCollectionChart->setProfile($objDataProfile);
   //     $DataCollectionChart->setActualAmount($data->getActualAmount());
   

        $this->EM->persist($DataCollectionChart);
        $this->EM->flush();

        return ["ok", $DataCollectionChart];
    }
    public function _updateDataCollectionChart($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataCollectionChart::class, 'json');

        $Id =   $data->getId();
        $profileId =   $data->getProfileId();
        $collectionId =   $data->getCollectionId();

        $RefDataCollectionChart = $this->EM->getRepository(DataCollectionChart::class);
        $objDataCollectionChart = $RefDataCollectionChart->findOneBy(['id' => $Id]);

        if ($objDataCollectionChart == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }

        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $profileId]);
        if ($objDataProfile == null) {
            return ["error", "DataProfile Id is Invalid"];
        }

        $RefRefCollectionChart = $this->EM->getRepository(RefCollectionChart::class);
        $objRefCollectionChart = $RefRefCollectionChart->findOneBy(['id' => $collectionId]);

        if ($objRefCollectionChart == null) {
            return    ["error", "RefCollectionChart Id is Invalid"];
        }


        $objDataCollectionChart->setDueAmount($data->getDueAmount());
$objDataCollectionChart->setDateOfDueGiven(new \DateTime());
        $objDataCollectionChart->setPenaltyAmount($data->getPenaltyAmount());
        $objDataCollectionChart->setProfile($objDataProfile);
        $objDataCollectionChart->setActualAmount($data->getActualAmount());
       
        $this->EM->persist($objDataCollectionChart);
        $this->EM->flush();



        return ["ok", $objDataCollectionChart];
    }
    public function _updateDataCollectionChartV1($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataCollectionChart::class, 'json');

        $Id =   $data->getId();
        $profileId =   $data->getProfileId();
       

        $RefDataCollectionChart = $this->EM->getRepository(DataCollectionChart::class);
        $objDataCollectionChart = $RefDataCollectionChart->findOneBy(['id' => $Id]);

        if ($objDataCollectionChart == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }

        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $profileId]);
        if ($objDataProfile == null) {
            return ["error", "DataProfile Id is Invalid"];
           
        }

        // $RefRefCollectionChart = $this->EM->getRepository(RefCollectionChart::class);
        // $objRefCollectionChart = $RefRefCollectionChart->findOneBy(['id' => $collectionId]);

        // if ($objRefCollectionChart == null) {
        //     return    ["error", "RefCollectionChart Id is Invalid"];
        // }


        $objDataCollectionChart->setDueAmount($data->getDueAmount());
//$objDataCollectionChart->setDateOfDueGiven(new \DateTime());
        $objDataCollectionChart->setPenaltyAmount($data->getPenaltyAmount());
        $objDataCollectionChart->setProfile($objDataProfile);
        $objDataCollectionChart->setActualAmount($data->getActualAmount());
        $objDataCollectionChart->setWeekNumber($data->getWeekNumber());

        $RefDataCollectionChart1 = $this->EM->getRepository(DataCollectionChart::class);
        $objDataCollectionChart1 = $RefDataCollectionChart1->findBy(['profile' => $profileId]);
        $i=1;
        $prev_date = 0;
           foreach ($objDataCollectionChart1 as $value) {
         
           
           
         
            if($i==1){
                $prev_date= date("l") ;
                 $value->setDateOfDueGiven(new \DateTime( ));
                }
                else{
                    $value->setDateOfDueGiven(new \DateTime($prev_date));
                }
               
              
                $prev_date= strtotime( $prev_date.' + 7 day' );

                $prev_date = date('Y-m-d', $prev_date);
                
 
                $i=$i+1; 
                $this->EM->persist($value);
                $this->EM->flush();
                
           }
           $prev_date= date("l") ;
           $RefCategoriesrepo = $this->EM->getRepository(RefDaySlot::class);
           $objRefCategories = $RefCategoriesrepo->findOneBy(['name' => $prev_date]);

          
           $objDataProfile->setDaySlot($objRefCategories);

           $this->EM->persist($objDataProfile);
           $this->EM->flush();




        $this->EM->persist($objDataCollectionChart);
        $this->EM->flush();



        return ["ok", $objDataCollectionChart];
    }

    public function _getSingleDataCollectionChart($Id)
    {

        $RefDataCollectionChart = $this->EM->getRepository(DataCollectionChart::class);
        $objDataCollectionChart = $RefDataCollectionChart->findOneBy(['id' => $Id]);

        if ($objDataCollectionChart == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }
        return ["ok", $objDataCollectionChart];
    }
    
    public function _getDataCollectionChartV1($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataCollectionChart::class, 'json');
        $DataProfilearray = [];

        $fromDate =  $data->getFromdate();
     
        $profileId = $data->getProfileId();
        $daySlotId = $data->getDaySlotId();
        if ($daySlotId) {
        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findBy(['daySlot' => $daySlotId]);
     
        if ($objDataProfile) {
           
            foreach ($objDataProfile as $arrayOne) {
                $UserId =   $arrayOne->getId();
                $carrepo = $this->EM->getRepository(DataCollectionChart::class);
                $DataProfile = $carrepo->findBy(['profile' => $UserId]);
                if ($DataProfile) {
                    foreach ($DataProfile as $DataProfilearrayOne) {
                        $DataProfilearray[] =  $DataProfilearrayOne;
                    }                }
            }
           
        }
       
        }

        if($fromDate||$profileId){

        $query = "SELECT * FROM data_collection_chart 
               where    ";
       
        if ($profileId) {
            $query = $query . "profile_id ='$profileId' AND";
        }
        if ($fromDate) {
            $query = $query . "   date(date_of_due_given ) = '$fromDate ' AND";
        }

        if (substr($query, -3) == "AND") {
            $query1 =  substr($query, 0, -3);
        }
        $connection = $this->EM->getconnection();
        $objData = $connection->executeQuery($query1)->fetchAll();

        if ($objData) {
            foreach ($objData as $arrayOne) {
                $UserId =    $arrayOne['id'];
                $carrepo = $this->EM->getRepository(DataCollectionChart::class);
                $DataProfile = $carrepo->findOneBy(['id' => $UserId]);
                if ($DataProfile) {
                    $DataProfilearray[] =  $DataProfile;
                }
            }
        }
    }
    if($DataProfilearray == null){
        $carrepo = $this->EM->getRepository(DataCollectionChart::class);
        $objRefCategory = $carrepo->findAll();
        $DataProfilearray =  $objRefCategory;
      }
        return ["ok", $DataProfilearray];
    }
   
    public function _getDataCollectionChart()
    {

        $RefDataCollectionChart = $this->EM->getRepository(DataCollectionChart::class);
        $objDataCollectionChart = $RefDataCollectionChart->findAll();

        return ["ok", $objDataCollectionChart];
    }
    public function _getProfileDataCollectionChart()
    {
        $DataProfilearray = [];
        $RefDataCollectionChart = $this->EM->getRepository(DataProfile::class);
        $objDataCollectionChart = $RefDataCollectionChart->findAll();
        foreach ($objDataCollectionChart as $image) {
            $Id =   $image->getId();
            $resposityDataPhotos = $this->EM->getRepository(DataCollectionChart::class);
            $DataPhotos = $resposityDataPhotos->findOneBy(['profile' => $Id]);
            if ($DataPhotos) {
                $DataProfilearray[] =  $DataPhotos;
            }
        }
        return ["ok", $DataProfilearray];
    }
    public function _getSingleDataCollectionChartBasedOnProfile($profile)
    {

        $RefDataCollectionChart = $this->EM->getRepository(DataCollectionChart::class);
        $objDataCollectionChart = $RefDataCollectionChart->findBy(['profile' => $profile]);

        if ($objDataCollectionChart == null) {
            return    ["error", "profile Id is Invalid"];
        }
        return ["ok", $objDataCollectionChart];
    }
        public function _getdueAmountSingleDataCollectionChartfilter($request)
    {
 
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataCollectionChart::class, 'json');
        
        $profile = $data->getProfileId();


        $DataProfilearray = [];
        if($profile){
            $resposityDataPhotos = $this->EM->getRepository(DataCollectionChart::class);
            $DataPhotos = $resposityDataPhotos->findOneBy(['profile' => $profile,'dueAmount' => 0]);
            if ($DataPhotos) {
                $DataProfilearray[] =  $DataPhotos;
            } 
        }
        else{
        $RefDataProfile = $this->EM->getRepository(DataProfile::class);
        $objDataProfile = $RefDataProfile->findAll();
        if ($objDataProfile == null) {
            return "DataProfile Id is Invalid";
        }

        foreach ($objDataProfile as $image) {
            $Id =   $image->getId();
            $resposityDataPhotos = $this->EM->getRepository(DataCollectionChart::class);
            $DataPhotos = $resposityDataPhotos->findOneBy(['profile' => $Id,'dueAmount' => 0]);
            if ($DataPhotos) {
                $DataProfilearray[] =  $DataPhotos;
            }
        }
      }

        return $DataProfilearray;
    }
    public function _getSingleDataCollectionChartfilter($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataCollectionChart::class, 'json');

        $id = $data->getId();
        $dueAmount = $data->getDueAmount();
        $penaltyAmount =   $data->getPenaltyAmount();
        $profileId = $data->getProfileId();
        $collectionId = $data->getCollectionId();
        $DataProfilearray = [];
        $fromDate = $data->getFromdate();

        $query1 = "  SELECT * FROM `data_collection_chart` WHERE ";



        if ($id) {
            $query1 = $query1 . "   id ='$id' AND";
        }

        if ($collectionId) {
            $query1 = $query1 . "   collection_id   = '$collectionId '  AND";
        }

        if ($penaltyAmount) {
            $query1 = $query1 . "  penalty_amount  = '$penaltyAmount '  AND";
        }
        if ($profileId) {
            $query1 = $query1 . "  profile_id  = '$profileId '  AND";
        }
        if ($fromDate) {
            $query1 = $query1 . "  date_of_due_given  = '$fromDate '  AND";
        }



        if (substr($query1, -3) == "AND") {
            $query1 =  substr($query1, 0, -3);
        }
        //      return    $query ; OR `is_active`=  $isActive
        $connection = $this->EM->getconnection();
        $objData = $connection->executeQuery($query1)->fetchAll();

        if ($objData) {
            foreach ($objData as $image) {
                $Id = $image["id"];
                $resposityDataPhotos = $this->EM->getRepository(DataProfile::class);
                $DataProfile = $resposityDataPhotos->findOneBy(['id' => $Id]);
                if ($DataProfile) {

                    $DataProfilearray[] =  $DataProfile;
                }
            }
        }

        return $DataProfilearray;
    }
    
    public function _DeleteOfDataCollectionChart($Id)
    {

        $RefDataProfile = $this->EM->getRepository(DataCollectionChart::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "DataProfile Id is Invalid";
        }
        $this->EM->remove($objDataProfile);
        $this->EM->flush();

        return "ok";
    }
    public function _addRefCollectionChart($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, RefCollectionChart::class, 'json');


        $daySlotId =   $data->getDaySlotId();

        $RefRefDaySlot = $this->EM->getRepository(RefDaySlot::class);
        $objRefDaySlot = $RefRefDaySlot->findOneBy(['id' => $daySlotId]);

        if ($objRefDaySlot == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }

        $DataCollectionChart = new RefCollectionChart;
        $DataCollectionChart->setWeekNo($data->getWeekNo());
        $DataCollectionChart->setAmount($data->getAmount());
        $DataCollectionChart->setDaySlot($objRefDaySlot);

        $DataCollectionChart->setIsActive(true);
        $this->EM->persist($DataCollectionChart);
        $this->EM->flush();

        return ["ok", $DataCollectionChart];
    }
    public function _updateRefCollectionChart($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, RefCollectionChart::class, 'json');

        $Id =   $data->getId();

        $daySlotId =   $data->getDaySlotId();

        $RefRefCollectionChart = $this->EM->getRepository(RefCollectionChart::class);
        $objRefCollectionChart = $RefRefCollectionChart->findOneBy(['id' => $Id]);

        if ($objRefCollectionChart == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }

        $RefRefDaySlot = $this->EM->getRepository(RefDaySlot::class);
        $objRefDaySlot = $RefRefDaySlot->findOneBy(['id' => $daySlotId]);

        if ($objRefDaySlot == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }

        $objRefCollectionChart->setWeekNo($data->getWeekNo());

        $objRefCollectionChart->setAmount($data->getAmount());
        $objRefCollectionChart->setDaySlot($objRefDaySlot);


        $objRefCollectionChart->setIsActive(true);


        $this->EM->persist($objRefCollectionChart);
        $this->EM->flush();



        return ["ok", $objRefCollectionChart];
    }
    public function _getSingleRefCollectionChart($Id)
    {

        $RefDataCollectionChart = $this->EM->getRepository(RefCollectionChart::class);
        $objDataCollectionChart = $RefDataCollectionChart->findOneBy(['id' => $Id]);

        if ($objDataCollectionChart == null) {
            return    ["error", "RefDaySlot Id is Invalid"];
        }
        return ["ok", $objDataCollectionChart];
    }
 
    public function _getRefCollectionChartAll()
    {

        $RefDataCollectionChart = $this->EM->getRepository(RefCollectionChart::class);
        $objDataCollectionChart = $RefDataCollectionChart->findAll();

        return ["ok", $objDataCollectionChart];
    }
    public function _updateStatusChangeEnableRefCollectionChart($Id)
    {

        $RefRefCollectionChart = $this->EM->getRepository(RefCollectionChart::class);
        $objRefCollectionChart = $RefRefCollectionChart->findOneBy(['id' => $Id]);
        if ($objRefCollectionChart == null) {
            return "RefCollectionChart Id is Invalid";
        }

        $objRefCollectionChart->setIsActive(true);
        $this->EM->persist($objRefCollectionChart);
        $this->EM->flush();
        return $objRefCollectionChart;
    }


    public function _updateStatusChangeDisableRefCollectionChart($Id)
    {

        $RefRefCollectionChart = $this->EM->getRepository(RefCollectionChart::class);
        $objRefCollectionChart = $RefRefCollectionChart->findOneBy(['id' => $Id]);
        if ($objRefCollectionChart == null) {
            return "RefCollectionChart Id is Invalid";
        }

        $objRefCollectionChart->setIsActive(false);
        $this->EM->persist($objRefCollectionChart);
        $this->EM->flush();
        return $objRefCollectionChart;
    }
    public function _getRefCollectionChartStatusChangeEnable()
    {

        $RefDataCollectionChart = $this->EM->getRepository(RefCollectionChart::class);
        $objDataCollectionChart = $RefDataCollectionChart->findBy(['isActive' => 1]);

        if ($objDataCollectionChart == null) {
            return    ["error", " Invalid"];
        }
        return ["ok", $objDataCollectionChart];
    }
    public function _DeleteOfRefCollectionChart($Id)
    {

        $RefDataProfile = $this->EM->getRepository(RefCollectionChart::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "RefCollectionChart Id is Invalid";
        }
        $this->EM->remove($objDataProfile);
        $this->EM->flush();

        return "ok";
    }
    public function _DataProfileWithUser($userName)
    {
        $DataProfilearray = [];
        $query = "SELECT * FROM data_profile 
               where  `name` like '%$userName%' ";
        $connection = $this->EM->getconnection();
        $objData = $connection->executeQuery($query)->fetchAll();
        if ($objData) {
            foreach ($objData as $arrayOne) {
                $UserId =    $arrayOne['id'];
                $carrepo = $this->EM->getRepository(DataProfile::class);
                $DataProfile = $carrepo->findOneBy(['id' => $UserId]);
                if ($DataProfile) {
                    $DataProfilearray[] =  $DataProfile;
                }
            }
            return  $DataProfilearray;
        } else {
            return   $DataProfilearray;
        }
    }
    public function _DataProfileWithuniqueCodeNo ($uniqueCodeNo)
    {
        $DataProfilearray = [];
        $query = "SELECT * FROM data_profile 
               where  `unique_code_no` like '%$uniqueCodeNo%' ";
        $connection = $this->EM->getconnection();
        $objData = $connection->executeQuery($query)->fetchAll();
        if ($objData) {
            foreach ($objData as $arrayOne) {
                $UserId =    $arrayOne['id'];
                $carrepo = $this->EM->getRepository(DataProfile::class);
                $DataProfile = $carrepo->findOneBy(['id' => $UserId]);
                if ($DataProfile) {
                    $DataProfilearray[] =  $DataProfile;
                }
            }
            return  $DataProfilearray;
        } else {
            return   $DataProfilearray;
        }
    }
    public function _addRefAttachmentType($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, RefAttachmentType::class, 'json');
        $attachment = new RefAttachmentType;
        $attachment->setName($data->getName());
        $attachment->setIsActive(true);
        $this->EM->persist($attachment);
        $this->EM->flush();
        return $attachment;
    }

    public function _updateRefAttachmentType($attachment_id, $request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, RefAttachmentType::class, 'json');
        $RefAttachmentTyperepo = $this->EM->getRepository(RefAttachmentType::class);
        $attachment = $RefAttachmentTyperepo->findOneBy(['id' => $attachment_id]);
        if ($attachment == null) {
            return "Invalid attachmentId";
        }
        $attachment->setName($data->getName());
        $this->EM->persist($attachment);
        $this->EM->flush();
        return $attachment;
    }

    public function _updateRefAttachmentTypeChange($RefAttachmentType_id, $status)
    {
        $RefAttachmentTyperepo = $this->EM->getRepository(RefAttachmentType::class);
        $objRefAttachmentType = $RefAttachmentTyperepo->findOneBy(['id' => $RefAttachmentType_id]);
        if ($objRefAttachmentType == null) {
            return "Invalid attachmentId";
        }
        if ($status == 'enable') {
            $objRefAttachmentType->setIsActive(true);
            $this->EM->persist($objRefAttachmentType);
            $this->EM->flush();
            return $objRefAttachmentType;
        }
        if ($status == 'disable') {
            $objRefAttachmentType->setIsActive(false);
            $this->EM->persist($objRefAttachmentType);
            $this->EM->flush();
            return $objRefAttachmentType;
        } else {
            return "Error";
        }
    }
    public function _getRefAttachmentTypeStatusChangeEnable()
    {

        $RefDataCollectionChart = $this->EM->getRepository(RefAttachmentType::class);
        $objDataCollectionChart = $RefDataCollectionChart->findBy(['isActive' => 1]);

        if ($objDataCollectionChart == null) {
            return    ["error", " Invalid"];
        }
        return ["ok", $objDataCollectionChart];
    }
    public function _getSingleRefAttachmentType($RefAttachmentType_id)
    {
        $RefAttachmentTyperepo = $this->EM->getRepository(RefAttachmentType::class);
        $objRefAttachmentType = $RefAttachmentTyperepo->findOneBy(['id' => $RefAttachmentType_id]);
        if ($objRefAttachmentType == null) {
            return "Invalid attachmentId";
        }
        return $objRefAttachmentType;
    }

    public function _getAllRefAttachmentType()
    {
        $RefAttachmentTyperepo = $this->EM->getRepository(RefAttachmentType::class);
        $objRefAttachmentType = $RefAttachmentTyperepo->findAll();
        return $objRefAttachmentType;
    }
    public function _DeleteOfRefAttachmentType($Id)
    {

        $RefDataProfile = $this->EM->getRepository(RefAttachmentType::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "RefAttachmentType Id is Invalid";
        }

        $this->EM->remove($objDataProfile);
        $this->EM->flush();

        return "ok";
    }
    public function _getSingleDataCollectionChartfilterV1($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, DataCollectionChart::class, 'json');

        $id = $data->getId();
        $dueAmount = $data->getDueAmount();
        $penaltyAmount =   $data->getPenaltyAmount();
        $profileId =[];
        $collectionId = $data->getCollectionId();
        $DataProfilearray = [];
        $fromDate = $data->getFromdate();
        $name = $data->getName();
        $uniqueCodeNo = $data->getUniqueCodeNo();
        $weekNo = $data->getWeekNo();
        $daySlotId = $data->getDaySlotId();
        $collectionId=[];
if(   $name||    $uniqueCodeNo  ){
      
    $query = "  SELECT * FROM `data_profile` WHERE ";
    
    
    if ($name) {
        $query = $query . "   name ='$name' AND";
    }
    if ($uniqueCodeNo) {
        $query = $query . "   unique_code_no ='$uniqueCodeNo' AND";
    }

    if (substr($query, -3) == "AND") {
        $query =  substr($query, 0, -3);
    } 
  
    $connection = $this->EM->getconnection();
    $objDataProfile = $connection->executeQuery($query)->fetchAll();

          if ($objDataProfile) {
            foreach ($objDataProfile as $objDataProfile1) {
                $Id = $objDataProfile1["id"];
                // $resposityDataPhotos = $this->EM->getRepository(DataProfile::class);
                // $DataProfile = $resposityDataPhotos->findOneBy(['id' => $Id]);
                // if ($DataProfile) {
                    $profileId[] =  $Id;
                // }
            }
                               }
}

if($weekNo || $daySlotId  ){
    $querychart = "  SELECT * FROM `ref_collection_chart` WHERE ";
    
    
    if ($weekNo) { 
        $querychart = $querychart . "   week_no ='$weekNo' AND";
    }
    if ($daySlotId) {
        $querychart = $querychart . "   day_slot_id ='$daySlotId' AND";
    }

    if (substr($querychart, -3) == "AND") {
        $querychart =  substr($querychart, 0, -3);
    } 
    $connection = $this->EM->getconnection();
    $objRefCollectionChart = $connection->executeQuery($querychart)->fetchAll();
    if ($objRefCollectionChart) {

        foreach ($objRefCollectionChart as $objRefCollectionChart1) {
            $Id = $objRefCollectionChart1["id"];
                 $collectionId[]=  $Id ;       
                 
        }   
               }

}

// $profileId1=   implode('/',/,$profileId ); 
$profileId1=   implode(",",$profileId ); 
$collectionId1=   implode(",",$collectionId ); 
if(   $collectionId||    $profileId || $profileId1 ||  $fromDate  ){
        $query1 = "  SELECT * FROM `data_collection_chart` WHERE ";

        if ($id) {
            $query1 = $query1 . "   id ='$id' AND";
        }

        if ($collectionId) {
            $query1 = $query1 . "   collection_id  in ( $collectionId1 )  AND";
        }

        // if ($penaltyAmount) {
        //     $query1 = $query1 . "  penalty_amount  = '$penaltyAmount '  AND";
        // }"uniqueCodeNo":"null"
     
        if ($profileId) {
            $query1 = $query1 . "  profile_id  in  ($profileId1 ) AND";
        }
        if ($fromDate) {
            $query1 = $query1 . " date(date_of_due_given ) = '$fromDate '  AND";
        }


// //         {
// //             "name":"jack",
// //             "uniqueCodeNo":"",
// // "fromDate":""
//        "weekNo":,
//        "daySlotId":
// //         }

        if (substr($query1, -3) == "AND") {
            $query1 =  substr($query1, 0, -3);
        }
      //  return    $query1 ;
        //      return    $query ; OR `is_active`=  $isActive
        $connection = $this->EM->getconnection();
        $objData = $connection->executeQuery($query1)->fetchAll();

        if ($objData) {
            foreach ($objData as $image) {
                $Id = $image["id"];
                $resposityDataPhotos = $this->EM->getRepository(DataCollectionChart::class);
                $DataProfile = $resposityDataPhotos->findOneBy(['id' => $Id]);
                if ($DataProfile) {

                    $DataProfilearray[] =  $DataProfile;
                }
            }
        }
    }
        return $DataProfilearray;
    }
    public function _addRefDaySlot($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, RefDaySlot::class, 'json');

        // $name = "adsfadsf";

        $table = new RefDaySlot;
        $table->setName($data->getName());
       
        $table->setIsActive(true);
        $this->EM->persist($table);
        $this->EM->flush();
        
        return ["ok", $table];
    }

    public function _updateRefDaySlot($table_id, $request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, RefDaySlot::class, 'json');

        $RefCategoriesrepo = $this->EM->getRepository(RefDaySlot::class);
        $objRefCategories = $RefCategoriesrepo->findOneBy(['id' => $table_id]);
        if ($objRefCategories == null) {
            return    ["error", "Invalid tableId"];
            
 
        }
        $objRefCategories->setName($data->getName());
       
        $this->EM->persist($objRefCategories);
        $this->EM->flush();
        return ["ok", $objRefCategories];
      

    }
    public function _getSingleRefDaySlot($table_id)
    {
        $RefCategoriesrepo = $this->EM->getRepository(RefDaySlot::class);
        $objRefCategories = $RefCategoriesrepo->findOneBy(['id' => $table_id]);
        if ($objRefCategories == null) {
            return "Invalid tableId";
        }
        return $objRefCategories;
    }
    public function _getRefDaySlot()
    {
        $RefCategoriesrepo = $this->EM->getRepository(RefDaySlot::class);
        $objRefCategories = $RefCategoriesrepo->findAll();
        if ($objRefCategories == null) {
            return "Invalid tableId";
        }
        return $objRefCategories;
    }
    public function _DeleteOfRefDaySlot($Id)
    {

        $RefDataProfile = $this->EM->getRepository(RefDaySlot::class);
        $objDataProfile = $RefDataProfile->findOneBy(['id' => $Id]);
        if ($objDataProfile == null) {
            return "RefDaySlot Id is Invalid";
        }
        $this->EM->remove($objDataProfile);
        $this->EM->flush();

        return "ok";
    }
    public function _getRefCollectionChartDaySlot($request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, RefCollectionChart::class, 'json');
        $DataProfilearray = [];

        $weekNo =  $data->getWeekNo();
        $daySlotId =   $data->getDaySlotId();


        $query = "SELECT * FROM ref_collection_chart 
               where    ";
       
        if ($daySlotId) {
            $query = $query . "   day_slot_id ='$daySlotId' AND";
        }
        if ($weekNo) {
            $query = $query . "   week_no ='$weekNo' AND";
        }
        if (substr($query, -3) == "AND") {
            $query1 =  substr($query, 0, -3);
        }
        $connection = $this->EM->getconnection();
        $objData = $connection->executeQuery($query1)->fetchAll();

        if ($objData) {
            foreach ($objData as $arrayOne) {
                $UserId =    $arrayOne['id'];
                $carrepo = $this->EM->getRepository(RefCollectionChart::class);
                $DataProfile = $carrepo->findOneBy(['id' => $UserId]);
                if ($DataProfile) {
                    $DataProfilearray[] =  $DataProfile;
                }
            }
        }
        // if ($objDataCollectionChart == null) {
        //     return    ["error", "RefDaySlot Id is Invalid"];
        // }
        return ["ok", $DataProfilearray];
    }
    public function _updateRefDaySlotTypeChange($RefDaySlot, $status)
    {
        $RefAttachmentTyperepo = $this->EM->getRepository(RefDaySlot::class);
        $objRefAttachmentType = $RefAttachmentTyperepo->findOneBy(['id' => $RefDaySlot]);
        if ($objRefAttachmentType == null) {
            return "Invalid RefDaySlot";
        }
        if ($status == 'enable') {
            $objRefAttachmentType->setIsActive(true);
            $this->EM->persist($objRefAttachmentType);
            $this->EM->flush();
            return $objRefAttachmentType;
        }
        if ($status == 'disable') {
            $objRefAttachmentType->setIsActive(false);
            $this->EM->persist($objRefAttachmentType);
            $this->EM->flush();
            return $objRefAttachmentType;
        } else {
            return "Error";
        }
    }
    public function _getRefDaySlotStatusChangeEnable()
    {

        $RefDataCollectionChart = $this->EM->getRepository(RefDaySlot::class);
        $objDataCollectionChart = $RefDataCollectionChart->findBy(['isActive' => 1]);

        if ($objDataCollectionChart == null) {
            return    ["error", " Invalid"];
        }
        return ["ok", $objDataCollectionChart];
    }
}


// http://127.0.0.1:8000/api/datacollection/filterv1
// {
//     "name":"jack"

// }
// $RefAttachmentTyperepo = $this->EM->getRepository(DataProfile::class);
// $objDataProfile = $RefAttachmentTyperepo->findBy(['name' =>  $name , 'uniqueCodeNo' =>  $uniqueCodeNo]);
// return $objDataProfile;











