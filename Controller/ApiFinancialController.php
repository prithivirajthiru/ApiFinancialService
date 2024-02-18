<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ApiFinancialService;
use App\Utils\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
class ApiFinancialController extends AbstractController
{
    #[Route('/api/financial', name: 'app_api_financial')]
    public function index(): Response
    {
        return $this->render('api_financial/index.html.twig', [
            'controller_name' => 'ApiFinancialController',
        ]);
    }
    #[Route("api/profile/add", name: "addDataProfile", methods: "POST")]

    public function addDataProfile(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_addDataProfile($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    
    #[Route("api/profile/addv1", name: "addDataProfilev1", methods: "POST")]
    public function addDataProfilev1(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_addDataProfileV1($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/profile/addv2", name: "addDataProfilev2", methods: "POST")]
    public function addDataProfilev2(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_addDataProfileV2($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }

    #[Route("api/profile/update", name: "updateDataProfile", methods: "PUT")]
    public function updateDataProfile(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_updateDataProfile($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/profile/enable/{id}", name: "updateStatusChangeEnable", methods: "PUT")]
    public function updateStatusChangeEnable( $id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_updateStatusChangeEnable($id);
        if ($category == "DataProfile Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/profile/disable/{id}", name: "updateStatusChangeDisable", methods: "PUT")]
    public function updateStatusChangeDisable( $id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_updateStatusChangeDisable($id);
        if ($category == "DataProfile Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }

    #[Route("api/getProfile/{id}", name:"getSingle", methods:"GET")]
    public function getSingle( $id,ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getSingle($id);
        if ($category == "DataProfile Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success");
    }
    #[Route("api/isactive/allprofile", name: "getDataProfileStatusChangeEnable", methods: "GET")]
    public function getDataProfileStatusChangeEnable(ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getDataProfileStatusChangeEnable();
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/profile/getsingle/{id}", name: "getSingleDataProfile", methods: "GET")]
    public function getSingleDataProfile($id, ApiFinancialService $ApiFinancialService)
    {
        
        $category = $ApiFinancialService->_getSingleDataProfile($id);
        if ($category == "DataProfile Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success");
    }

    #[Route("api/list/getallprofile", name: "getAllProfile", methods: "GET")]
    public function getAllProfile(ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getAllProfile();
        if ($category == "DataProfile Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success",['timezone']);
    }
    #[Route("/api/user/login", name: "userLogin", methods: "POST")]
    public function userLogin(Request $request,  ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_userLogin($request);
        
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    // #[Route("api/list/getprofile", name: "getProfile", methods: "GET")]
    // public function getProfile(ApiFinancialService $ApiFinancialService)
    // {
    //     $category = $ApiFinancialService->_getProfile();
    //     if ($category == "DataProfile Id is Invalid") {
    //         return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
    //     }
    //     return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success",['timezone']);
    // }
    #[Route("api/list/getsingle/{id}", name: "getProfile1", methods: "GET")]
    public function getProfile1($id,ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getProfile1($id);
        if ($category == "DataProfile Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success",['timezone']);
    }
    #[Route("api/profile/filter", name: "getSingleDataProfile1", methods: "POST")]

    public function getSingleDataProfile1(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getSingleDataProfile1($request);

        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/profile/delete/{id}", name: "DeleteOfDataProfile", methods: "PUT")]
    public function DeleteOfDataProfile($id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_DeleteOfDataProfile($id);
        if ($category == "DataProfile Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    
    #[Route("api/attachment/fileupload", name: "fileUploadOfRefCategory", methods: "POST")]
    public function fileUploadOfRefCategory(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_fileUploadOfRefCategory($request);
        if ($category == "Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success");
    }
    #[Route("api/fileupload/get/{id}", name: "getfileUploadOfRefCategory", methods: "GET")]
    public function getfileUploadOfRefCategory($id, ApiFinancialService $ApiFinancialService)
    {
        
        $category = $ApiFinancialService->_getfileUploadOfRefCategory($id);
        if ($category == "DataProfile Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success");
    }
    #[Route("api/attachment/download/{id}", name: "filedownloadDataProduct", methods: "GET")]
    public function filedownloadDataProduct($id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_filedownloadDataProduct($id);
        return $category;
    }
    #[Route("api/file/delete/{id}", name: "DeleteOffile", methods: "PUT")]
    public function DeleteOffile($id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_DeleteOffile($id);
        if ($category == "file Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }

    #[Route("api/isactive/file", name: "getfileStatusChangeEnable", methods: "GET")]
    public function getfileStatusChangeEnable(ApiFinancialService $ApiFinancialService) 
    {
        $category = $ApiFinancialService->_getfileStatusChangeEnable();
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/datacollection/add", name: "addDataCollectionChart", methods: "POST")]

    public function addDataCollectionChart(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_addDataCollectionChart($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }

    #[Route("api/datacollection/update", name: "updateDataCollectionChart", methods: "PUT")]
    public function updateDataCollectionChart(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_updateDataCollectionChart($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/datacollection/updatev1", name: "updateDataCollectionChartv1", methods: "PUT")]
    public function updateDataCollectionChartv1(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_updateDataCollectionChartV1($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/datacollection/getsingle/{id}", name: "getSingleDataCollectionChart", methods: "GET")]
    public function getSingleDataCollectionChart($id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getSingleDataCollectionChart($id);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/datacollection/getAll", name: "getDataCollectionChart", methods: "GET")]
    public function getDataCollectionChart(ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getDataCollectionChart();
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/datacollection/getprofile", name: "getProfileDataCollectionChart", methods: "GET")]
    public function getProfileDataCollectionChart(ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getProfileDataCollectionChart();
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/datacollection/basedonprofile/{profileid}", name: "getSingleDataCollectionChartBasedOnProfile", methods: "GET")]
    public function getSingleDataCollectionChartBasedOnProfile($profileid, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getSingleDataCollectionChartBasedOnProfile($profileid);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/datacollection/duefilter", name: "getdueAmountSingleDataCollectionChartfilter", methods: "POST")]

    public function getdueAmountSingleDataCollectionChartfilter(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getdueAmountSingleDataCollectionChartfilter($request);

        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/datacollection/filter", name: "getSingleDataCollectionChartfilter", methods: "POST")]

    public function getSingleDataCollectionChartfilter(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getSingleDataCollectionChartfilter($request);

        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/datacollection/profile", name: "getDataCollectionChartV1", methods: "POST")]

    public function getDataCollectionChartV1(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getDataCollectionChartV1($request);

        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/attachmentId/delete/{id}", name: "DeleteOfRefAttachmentType", methods: "PUT")]
    public function DeleteOfRefAttachmentType($id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_DeleteOfRefAttachmentType($id);
        if ($category == "DataCollectionChart Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/refcollection/add", name: "addRefCollectionChart", methods: "POST")]

    public function addRefCollectionChart(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_addRefCollectionChart($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }

    #[Route("api/refcollection/update", name: "updateRefCollectionChart", methods: "PUT")]
    public function updateRefCollectionChart(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_updateRefCollectionChart($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/refcollection/enable/{Id}", name: "updateStatusChangeEnableRefCollectionChart", methods: "PUT")]
    public function updateStatusChangeEnableRefCollectionChart($Id, Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_updateStatusChangeEnableRefCollectionChart($Id, $request);
        if ($category == "DataProfile Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/refcollection/disable/{Id}", name: "updateStatusChangeDisableRefCollectionChart", methods: "PUT")]
    public function updateStatusChangeDisableRefCollectionChart($Id, Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_updateStatusChangeDisableRefCollectionChart($Id, $request);
        if ($category == "DataProfile Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/isactive/refcollection", name: "getRefCollectionChartStatusChangeEnable", methods: "GET")]
    public function getRefCollectionChartStatusChangeEnable(ApiFinancialService $ApiFinancialService) 
    {
        $category = $ApiFinancialService->_getRefCollectionChartStatusChangeEnable();
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/refcollection/getall", name: "getRefCollectionChartAll", methods: "GET")]
    public function getRefCollectionChartAll(ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getRefCollectionChartAll();
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }

    #[Route("api/refcollection/getsingle/{Id}", name: "getSingleRefCollectionChart", methods: "GET")]
    public function getSingleRefCollectionChart($Id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getSingleRefCollectionChart($Id);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }


    #[Route("api/refcollection/get", name: "getRefCollectionChartDaySlot", methods: "POST")]
    public function getRefCollectionChartDaySlot(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getRefCollectionChartDaySlot($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/profile/search/{name}", name: "DataProfileWithUser", methods: "GET")]
    public function DataProfileWithUser($name, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_DataProfileWithUser($name);

        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    
    #[Route("api/uniquecodeno/search/{uniqueCodeNo}", name: "DataProfileWithuniqueCodeNo", methods: "GET")]
    public function DataProfileWithuniqueCodeNo($uniqueCodeNo, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_DataProfileWithuniqueCodeNo($uniqueCodeNo);

        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/add/refattachmenttype", name: "addRefAttachmentType", methods: "POST")]
    public function addRefAttachmentType(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $attachment = $ApiFinancialService->_addRefAttachmentType($request);
        return new ApiResponse($attachment, 200, ["Content-Type" => "application/json"], 'json', "Success");
    }


    #[Route("api/update/refattachmenttype/{RefAttachmentType_id}", name: "updateRefAttachmentType", methods: "PUT")]
    public function updateRefAttachmentType($RefAttachmentType_id, Request $request, ApiFinancialService $ApiFinancialService)
    {
        $attachment = $ApiFinancialService->_updateRefAttachmentType($RefAttachmentType_id, $request);
        if ($attachment == "Invalid attachmentId") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $attachment, ['timezone']);
        }
        return new ApiResponse($attachment, 200, ["Content-Type" => "application/json"], 'json', "Success");
    }


    #[Route("api/update/refattachmenttype/{RefAttachmentType_id}/{status}", name: "updateRefAttachmentTypeChange", methods: "PUT")]
    public function updateRefAttachmentTypeChange($RefAttachmentType_id, $status, ApiFinancialService $ApiFinancialService)
    {
        $attachment = $ApiFinancialService->_updateRefAttachmentTypeChange($RefAttachmentType_id, $status);
        if ($attachment == "Invalid attachmentId") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $attachment, ['timezone']);
        }
        return new ApiResponse($attachment, 200, ["Content-Type" => "application/json"], 'json', "Success");
    }
    #[Route("api/isactive/refattachmenttype", name: "getRefAttachmentTypeStatusChangeEnable", methods: "GET")]
    public function getRefAttachmentTypeStatusChangeEnable(ApiFinancialService $ApiFinancialService) 
    {
        $category = $ApiFinancialService->_getRefAttachmentTypeStatusChangeEnable();
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }

    #[Route("api/get/refattachmenttype/{RefAttachmentType_id}", name: "getSingleRefAttachmentType", methods: "GET")]
    public function getSingleRefAttachmentType($RefAttachmentType_id, ApiFinancialService $ApiFinancialService)
    {
        $attachment = $ApiFinancialService->_getSingleRefAttachmentType($RefAttachmentType_id);
        if ($attachment == "Invalid attachmentId") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $attachment, ['timezone']);
        }
        return new ApiResponse($attachment, 200, ["Content-Type" => "application/json"], 'json', "Success");
    }

    #[Route("api/list/refattachmenttype", name: "getAllRefAttachmentType", methods: "GET")]
    public function getAllRefAttachmentType( ApiFinancialService $ApiFinancialService)
    {
        $attachment = $ApiFinancialService->_getAllRefAttachmentType();
        return new ApiResponse($attachment, 200, ["Content-Type" => "application/json"], 'json', "Success");
    }
    #[Route("api/chart/delete/{id}", name: "DeleteOfDataCollectionChart", methods: "PUT")]
    public function DeleteOfDataCollectionChart($id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_DeleteOfDataCollectionChart($id);
        if ($category == "DataCollectionChart Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/datacollection/filterv1", name: "getSingleDataCollectionChartfilterV1", methods: "POST")]

    public function getSingleDataCollectionChartfilterV1(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getSingleDataCollectionChartfilterV1($request);

        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }

    #[Route("api/refslot/add", name: "addRefDaySlot", methods: "POST")]

    public function addRefDaySlot(Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_addRefDaySlot($request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }

    #[Route("api/refslot/update/{table_id}", name: "updateRefDaySlot", methods: "PUT")]
    public function updateRefDaySlot($table_id,Request $request, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_updateRefDaySlot($table_id,$request);
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/refslot/getsingle/{id}", name: "getSingleRefDaySlot", methods: "GET")]
    public function getSingleRefDaySlot($id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getSingleRefDaySlot($id);
        if ($category == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/refslot/getAll", name: "getRefDaySlot", methods: "GET")]
    public function getRefDaySlot(ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_getRefDaySlot();
        if ($category == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/dayslot/delete/{id}", name: "DeleteOfRefDaySlot", methods: "PUT")]
    public function DeleteOfRefDaySlot($id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_DeleteOfRefDaySlot($id);
        if ($category == "RefDaySlot Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/refcollection/delete/{id}", name: "DeleteOfRefCollectionChart", methods: "PUT")]
    public function DeleteOfRefCollectionChart($id, ApiFinancialService $ApiFinancialService)
    {
        $category = $ApiFinancialService->_DeleteOfRefCollectionChart($id);
        if ($category == "RefCollectionChart Id is Invalid") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category, 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
    #[Route("api/update/dayslot/{RefDaySlot}/{status}", name: "updateRefDaySlotTypeChange", methods: "PUT")]
    public function updateRefDaySlotTypeChange($RefDaySlot, $status, ApiFinancialService $ApiFinancialService)
    {
        $attachment = $ApiFinancialService->_updateRefDaySlotTypeChange($RefDaySlot, $status);
        if ($attachment == "Invalid attachmentId") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $attachment, ['timezone']);
        }
        return new ApiResponse($attachment, 200, ["Content-Type" => "application/json"], 'json', "Success");
    }
    #[Route("api/isactive/dayslot", name: "getRefDaySlotStatusChangeEnable", methods: "GET")]
    public function getRefDaySlotStatusChangeEnable(ApiFinancialService $ApiFinancialService) 
    {
        $category = $ApiFinancialService->_getRefDaySlotStatusChangeEnable();
        if ($category[0] == "error") {
            return new ApiResponse([], 400, ["Content-Type" => "application/json"], 'json', $category[1], ['timezone']);
        }
        return new ApiResponse($category[1], 200, ["Content-Type" => "application/json"], 'json', "Success", ['timezone', "__initializer__", "__cloner__", "__isInitialized__"]);
    }
}





