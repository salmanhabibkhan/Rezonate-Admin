<?php

namespace App\Controllers;

use App\Models\Page;
use App\Models\ProductCategory;
use Firebase\JWT\JWT;
use App\Models\Product;
use App\Models\LikePage;
use App\Models\PostModel;
use App\Models\ProductMedia;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class ProductController extends BaseController
{
    use ResponseTrait;
    public function addProduct()
    {
        
        $rules = [
            'product_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.product_name_required'),
                ]
            ],
            'product_description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.product_description_required'),
                ]
            ],
            'category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.category_required'),
                ]
            ],
            'price' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.price_required'),
                ]
            ],
            'location' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.location_required'),
                ]
            ],
            'type' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.type_required'),
                ]
            ],
            'currency' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.currency_required'),
                ]
            ],
            'units' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.units_required'),
                ]
            ],
            'images' => [
                'rules' => 'uploaded[images]|ext_in[images,png,jpg,jpeg]|is_image[images]',
                'errors' => [
                    'uploaded' => lang('Api.images_required'),
                    'ext_in' => lang('Api.images_ext_in'),
                    'is_image' => lang('Api.images_is_image'),
                ]
            ]
        ];


        if ($this->validate($rules)) {

            $productModel = new Product;
            $inserted_data = [
                'user_id' => getCurrentUser()['id'],
                'product_name' => $this->request->getVar('product_name'),
                'product_description' => $this->request->getVar('product_description'),
                'category' => $this->request->getVar('category'),
                'sub_category' => $this->request->getVar('sub_category'),
                'price' => $this->request->getVar('price'),
                'location' => $this->request->getVar('location'),
                'currency' => $this->request->getVar('currency'),
                'type' => $this->request->getVar('type'),
                'units' => $this->request->getVar('units'),
            ];

            if ($productModel->save($inserted_data)) {
                $product_id = $productModel->insertID();

                $files = $this->request->getFiles('images');
                if (!empty($files)) {
                    foreach ($files['images'] as $file) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            try {
                                // Use the storeMedia function to handle file upload
                                $uploadedImagePath = storeMedia($file, 'products');

                                // Save file information in the database
                                $productMediaModel = new ProductMedia;
                                $productMediaData = [
                                    'product_id' => $product_id,
                                    'image' => $uploadedImagePath,
                                ];
                                $productMediaModel->save($productMediaData);
                            } catch (\Exception $e) {
                                // Handle the exception, log or respond accordingly
                                return $this->respond([
                                    'code' => '500',
                                    'message' => lang('Api.internal_server_error') . ': ' . $e->getMessage(),
                                    'data' => 'failed'
                                ], 500);
                            }
                        }
                    }
                }
                // Create  Post for product
                $postModel = new PostModel;
                $postdata = [
                    'user_id' => getCurrentUser()['id'],
                    'post_text' => '',
                    'post_type' => 'post',
                    'image_or_video' => 0,
                    'privacy' =>  1,
                    'ip' => $this->request->getIPAddress(),
                    'post_location' =>  '',
                    'post_color_id' =>  0,
                    'width' =>  0,
                    'height' =>  0,
                    'page_id' =>  0,
                    'group_id' =>  0,
                    'event_id' =>  0,

                    'product_id' =>  $product_id,

                ];

                $postModel->save($postdata);

                $productdata = $productModel->getProduct($product_id);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.product_added_successfully'),
                    'data' => $productdata
                ], 200);
            } else {
                return $this->respond([
                    'code' => '500',
                    'message' => lang('Api.internal_server_error'),
                    'data' => 'failed'
                ], 500);
            }
        } else {
            // Data did not meet the validation rules
            // Handle validation errors
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_errors'),
                'data' => $validationErrors
            ], 400);
        }
    }
    public function createProduct()
    {
        $categoriesModel  = New ProductCategory();
        $this->data['categories'] = $categoriesModel->findAll();
        echo load_view('pages/products/create-product', $this->data);
    }

    public function getProductDetail($product_id = 0)
    {
        $productModel = new Product;
        $product = $productModel->getProduct($product_id);
        if ($product) {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.success'),
                'data' => $product
            ], 200);
        } else {
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.product_not_found'),
                'data' => ''
            ], 404);
        }
    }


    public function getProductsWeb()
    {
        $productModel = new Product();
        $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;
        $user_id = getCurrentUser()['id'];
        $category = $this->request->getVar('category');

        if (!empty($category)) {
            $products = $productModel
                ->where('user_id !=', $user_id)
                ->where('category', $category)
                ->findAll($limit, $offset);
        } else {
            $products = $productModel
                ->where('user_id !=', $user_id)
                ->findAll($limit, $offset);
        }
        $this->data['category'] = $category;
        // Compile product data if needed
        foreach ($products as &$product) {
            $product = $productModel->compile_product_data($product);
        }
        $sliderproducts = $productModel
            ->where('user_id !=', $user_id)
            ->orderBy('RAND()')
            ->findAll(4);
        foreach ($sliderproducts as &$sp) {
            $sp = $productModel->compile_product_data($sp);
        }

        $this->data['sliderproducts'] = $sliderproducts;

        $this->data['products'] = $products;


        // Load necessary CSS and JS files
        $this->data['js_files'] = ['js/products.js'];
        $this->data['css_files'] = ['css/products.css'];
        $this->data['is_full_layout'] = 1;

        echo load_view('pages/products/products_main', $this->data);
    }
    public function getMyProductsWeb()
    {

        $productModel = new Product;
        $this->data['category'] = $this->request->getVar('category');
        $productModel = new Product;
        $user_id = getCurrentUser()['id'];
        $products = $productModel->where('user_id', $user_id)->findAll();

        foreach ($products as &$product) {
            $product = $productModel->compile_product_data($product);
        }
        $this->data['products'] = $products;
        $sliderproducts = $productModel
            ->where('user_id !=', $user_id)
            ->orderBy('RAND()')
            ->findAll(4);
        $this->data['is_full_layout'] = 1;
        foreach ($sliderproducts as &$sp) {
            $sp = $productModel->compile_product_data($sp);
        }

        $this->data['sliderproducts'] = $sliderproducts;
        echo load_view('pages/products/my-products', $this->data);
    }
    public function productDetails($id)
    {
        $productModel = new Product;
        $this->data['product'] = $productModel->getProduct($id);
        echo load_view('pages/products/product_details', $this->data);
    }
    public function editProduct($id)
    {
        $productModel = new Product;
        $product = $productModel->find($id);
        $user_id = getCurrentUser()['id'];
        if ($product['user_id'] == $user_id) {
            $this->data['product'] = $product;
            $productMediaModel = new ProductMedia;
            $this->data['images'] = $productMediaModel->where('product_id', $id)->findAll();
            $categoriesModel  = New ProductCategory();
            $this->data['categories'] = $categoriesModel->findAll();
            echo load_view('pages/products/edit-product', $this->data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function getMyProducts()
    {


        $user_id = $this->request->getVar('user_id');
        $productModel = new Product;
        $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;

        if (!empty($user_id)) {
            if ($user_id == getCurrentUser()['id']) {
                $products = $productModel->where('user_id', $user_id)->orderBy('id', 'desc')->findAll($limit, $offset);
                foreach ($products as &$product) {
                    $product = $productModel->compile_product_data($product);
                }
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.fetch_user_product_success'),
                    'data' => $products
                ], 200);
            } else {
                return $this->respond([
                    'code' => '403',
                    'message' => lang('Api.invalid_user_id'),
                    'data' => ''
                ], 400);
            }
        } else {
            $productModel = new Product;
            $user_id = getCurrentUser()['id'];
            $products = $productModel->where('user_id !=', $user_id)->findAll($limit, $offset);

            foreach ($products as &$product) {
                $product = $productModel->compile_product_data($product);
            }

            return $this->respond([
                'code' => '200',
                'message' => lang('Api.fetch_user_product_success'),
                'data' => $products
            ], 200);
        }
    }



    public function getProducts()
    {


        $user_id = $this->request->getVar('user_id');
        $productModel = new Product;
        $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;

        if (!empty($user_id)) {
            if ($user_id == getCurrentUser()['id']) {
                $products = $productModel->where('user_id', $user_id)->orderBy('id', 'desc')->findAll($limit, $offset);
                foreach ($products as &$product) {
                    $product = $productModel->compile_product_data($product);
                }
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.fetch_user_product_success'),
                    'data' => $products
                ], 200);
            } else {
                return $this->respond([
                    'code' => '403',
                    'message' => lang('Api.invalid_user_id'),
                    'data' => ''
                ], 400);
            }
        } else {
            $productModel = new Product;
            $user_id = getCurrentUser()['id'];
            $products = $productModel->where('user_id !=', $user_id)->findAll($limit, $offset);

            foreach ($products as &$product) {
                $product = $productModel->compile_product_data($product);
            }

            return $this->respond([
                'code' => '200',
                'message' => lang('Api.fetch_user_product_success'),
                'data' => $products
            ], 200);
        }
    }

    public function updateProduct()
    {

        $rules = [
            'product_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.product_id_required'),
                ]
            ],
            // Add other validation rules for the fields you want to update
        ];
    
    

        if ($this->validate($rules)) {


            // Check ownership or permission logic if needed
            // $product_data = $this->checkOwnership($this->request->getVar('product_id'));

            $product_id = $this->request->getVar('product_id');

            // Assuming you have a checkOwnership function for product ownership
            $product_data = $this->checkOwnership($product_id);

            if ($product_data == 200) {
                // Get all input data
                $deletedImagesids = $this->request->getVar('deleted_image_ids');
                if (!empty($deletedImagesids)) {
                    $idarray = explode(",", $deletedImagesids);
                    $productimageModel  = new ProductMedia;
                    $productimageModel->deleteimages($idarray);
                }

                $data = [];

                // Loop through all input values and add them to the update array
                $arraydata = $this->request->getPost();
                if (!empty($arraydata)) {
                    foreach ($arraydata as $key => $value) {
                        // Exclude the 'product_id' from the update array
                        if ($key != 'product_id' || $key != 'deleted_image_ids' || $key != 'images') {
                            $data[$key] = $value;
                        }
                    }

                    if (count($data) > 1) {
                        $productModel = new Product;
                        $productModel->update($product_id, $data);
                    }
                }



                // Handle file upload for images if needed
                $files = $this->request->getFiles('images');
                if (!empty($files)) {
                    foreach ($files['images'] as $file) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            try {
                                // Use the storeMedia function to handle file upload
                                $uploadedImagePath = storeMedia($file, 'products');

                                // Save file information in the database
                                $productMediaModel = new ProductMedia;
                                $productMediaData = [
                                    'product_id' => $product_id,
                                    'image' => $uploadedImagePath,
                                ];
                                $productMediaModel->save($productMediaData);
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

                // Update the product


                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.product_updated_successfully'),
                    'data' => $data
                ], 200);
            } elseif ($product_data == 401) {
                return $this->respond([
                    'code' => '401',
                    'message' => lang('Api.not_allowed'),
                    'data' => ''
                ], 401);
            } else {
                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.product_not_found'),
                    'data' => ''
                ], 404);
            }
        } else {
            // Validation failed
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_errors'),
                'data' => $validationErrors
            ], 400);
        }
    }
    public function deleteProduct()
    {
        $rules = [
            'product_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.product_id_required'),
                ]
            ]
        ];
    
        if ($this->validate($rules)) {
            $productMediaModel = new ProductMedia;
            $product_id = $this->request->getVar('product_id');
            $productMediaModel->deleteproductImageByImageId($product_id);
            $product = new Product;
            $product->delete($product_id);
            $postModel = new PostModel;
            $postModel->where('product_id', $product_id)->delete();
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.product_deleted_successfully'),
                'data' => ''
            ], 200);
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_errors'),
                'data' => $validationErrors
            ], 400);
        }
    }
    public function checkOwnership($product_id)
    {
        $user_data = getCurrentUser();
        $model = new Product;
        $product_data = $model->where('id', $product_id)->first();

        if (!empty($product_data)) {
            if ($product_data['user_id'] == $user_data['id']) {
                return 200;
            } else {
                return 401;
            }
        } else {
            return 404;
        }
    }
}
