<?php

namespace App\Controllers;

use App\Models\Page;
use Firebase\JWT\JWT;
use App\Models\offer;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class OfferController extends BaseController
{
    use ResponseTrait;
    public function addoffer()
    {
        $rules = [
            'offer_name' => 'required',
            'offer_description' => 'required',
            'category' => 'required',
            'price' => 'required',
            'location' => 'required',
            'type'=>'required',
            'currency' => 'required',
            'units'=>'required',
            'images' => 'uploaded[images]|max_size[images,2048]|ext_in[images,png,jpg,jpeg]|is_image[images]',
        ];

        if ($this->validate($rules)) {

            $offerModel = new offer;
            $inserted_data = [
                'user_id' => getCurrentUser()['id'],
                'offer_name' => $this->request->getVar('offer_name'),
                'offer_description' => $this->request->getVar('offer_description'),
                'category' => $this->request->getVar('category'),
                'sub_category' => $this->request->getVar('sub_category'),
                'price' => $this->request->getVar('price'),
                'location' => $this->request->getVar('location'),
                'currency' => $this->request->getVar('currency'),
                'type'=>$this->request->getVar('type'),
                'units'=>$this->request->getVar('units'),
            ];

            if ($offerModel->save($inserted_data)) {
                $offer_id = $offerModel->insertID();
                
                $files = $this->request->getFiles('images');
                if (!empty($files)) {
                    foreach ($files['images'] as $file) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            try {
                                // Use the storeMedia function to handle file upload
                                $uploadedImagePath = storeMedia($file, 'offers');
                                
                                // Save file information in the database
                                $offerMediaModel = new offerMedia;
                                $offerMediaData = [
                                    'offer_id' => $offer_id,
                                    'image' => $uploadedImagePath,
                                ];
                                $offerMediaModel->save($offerMediaData);
                            } catch (Exception $e) {
                                // Handle the exception, log or respond accordingly
                                return $this->respond([
                                    'code' => '500',
                                    'message' => 'Internal Server Error: ' . $e->getMessage(),
                                    'data' => 'failed'
                                ], 500);
                            }
                        }
                    }
                }

                return $this->respond([
                    'code' => '200',
                    'message' => 'offer added successfully',
                    'data' => $inserted_data
                ], 200);
            } else {
                return $this->respond([
                    'code' => '500',
                    'message' => 'Internal Server Error',
                    'data' => 'failed'
                ], 500);
            }
        } else {
            // Data did not meet the validation rules
            // Handle validation errors
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => 'Validation errors',
                'data' => $validationErrors
            ], 400);
        }
    }

    public function getofferDetail($offer_id=0){
      $offerModel = New offer;
      $offer = $offerModel->getoffer($offer_id);
      if($offer){
        return $this->respond([
                    'code' => '200',
                    'message' => 'Success',
                    'data' => $offer
                ], 200);
        }else{
            return $this->respond([
                    'code' => '404',
                    'message' => 'offer not found',
                    'data' => ''
                ], 404);
        }
   
    }

    public function getoffers()
    {
        $modifiedofferimages = [];
        $modifiedoffers = [];
        $user_id = $this->request->getVar('user_id');
        $offerModel = New offer;
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        
        if(!empty($user_id))
        {
            if($user_id == getCurrentUser()['id'])
            {
                $offers = $offerModel->where('user_id', $user_id)->findAll($limit, $offset);
                foreach ($offers as &$offer) {
                    $offer = compile_offer_data($offer);
                }
                return $this->respond([
                    'code' => '200',
                    'message' => 'Fetch User offer Successfully ',
                    'data' => $offers
                ], 200);
            }
            else{
                return $this->respond([
                    'code' => '403',
                    'message' => 'Invalid User Id ',
                    'data' => ''
                ], 400);
            }
        }
        else{
            $offerModel = New offer;
            $user_id = getCurrentUser()['id'];
            $offers = $offerModel->where('user_id !=', $user_id)->findAll($limit, $offset);
            $offers = $offerModel->where('user_id', $user_id)->findAll($limit, $offset);
            foreach ($offers as &$offer) {
                $offer = compile_offer_data($offer);
            }
            
            return $this->respond([
                'code' => '200',
                'message' => 'Fetch User offer Successfully ',
                'data' => $offers
            ], 200);

        }
        
    }

    public function updateoffer()
    {
     
        $rules = [
            'offer_id' => 'required',
            // Add other validation rules for the fields you want to update
        ];

        if ($this->validate($rules)) {
            $offerModel = new offer;

            // Check ownership or permission logic if needed
            // $offer_data = $this->checkOwnership($this->request->getVar('offer_id'));

            $offer_id = $this->request->getVar('offer_id');

            // Assuming you have a checkOwnership function for offer ownership
            $offer_data = $this->checkOwnership($offer_id);

            if ($offer_data == 200) {
                // Get all input data
                $deletedImagesids = $this->request->getVar('deleted_image_ids');
                if(!empty($deletedImagesids))
                {
                    $idarray = explode(",", $deletedImagesids);
                    $offerimageModel  = New offerMedia;
                    
                  
                    $offerimageModel->deleteimages($idarray);
                }
              
                $data = [];

                // Loop through all input values and add them to the update array
                foreach ($this->request->getPost() as $key => $value) {
                    // Exclude the 'offer_id' from the update array
                    if ($key != 'offer_id' || $key !='deleted_image_ids' ) {
                        $data[$key] = $value;
                    }
                }
                

                // Handle file upload for images if needed
                $files = $this->request->getFiles('images');
                if (!empty($files)) {
                    foreach ($files['images'] as $file) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            try {
                                // Use the storeMedia function to handle file upload
                                $uploadedImagePath = storeMedia($file, 'offers');

                                // Save file information in the database
                                $offerMediaModel = new offerMedia;
                                $offerMediaData = [
                                    'offer_id' => $offer_id,
                                    'image' => $uploadedImagePath,
                                ];
                                $offerMediaModel->save($offerMediaData);
                            } catch (\Exception $e) {
                                // Handle the exception, log or respond accordingly
                                return $this->respond([
                                    'code' => '500',
                                    'message' => 'Internal Server Error: ' . $e->getMessage(),
                                    'data' => 'failed'
                                ], 500);
                            }
                        }
                    }
                }

                // Update the offer
                $offerModel->update($offer_id, $data);

                return $this->respond([
                    'code' => '200',
                    'message' => 'offer fields updated successfully',
                    'data' => $data
                ], 200);
            } elseif ($offer_data == 401) {
                return $this->respond([
                    'code' => '401',
                    'message' => 'You are not allowed',
                    'data' => ''
                ], 401);
            } else {
                return $this->respond([
                    'code' => '404',
                    'message' => 'offer not found',
                    'data' => ''
                ], 404);
            }
        } else {
            // Validation failed
            $validationErrors = $this->validator->getErrors();
            return $this->response->setJSON($validationErrors);
        }
    }

    public function deleteoffer()
    {
        $rules = [
            'offer_id'=>'required'
        ];
        if ($this->validate($rules)) {
            $offerMediaModel = New offerMedia;
            $offer_id = $this->request->getVar('offer_id');
            $offerMediaModel->deleteofferImageByUserId($offer_id);
            $offer = New offer;
            $offer->delete($offer_id);
            
            return $this->respond([
                'code' => '200',
                'message' => 'The offer is deleted ',
                'data' => ''
            ], 200);
        }
        else{
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => 'Validation errors',
                'data' => $validationErrors
            ], 400);
        }    
    }

    public function checkOwnership($offer_id)
    {
        $user_data = getCurrentUser();
        $model = New offer;
        $offer_data = $model->where('id',$offer_id)->first();
        
        if(!empty($offer_data))
        {
            if($offer_data['user_id']==$user_data['id'])
            {
                return 200;
            }
            else{
                return 401;
            }
            
        }
        else{
           return 404;
        }
    }

}