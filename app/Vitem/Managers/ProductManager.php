<?php namespace Vitem\Managers;

use Vitem\Repositories\PermissionRepo;
use Vitem\Validators\ProductValidator;
use Vitem\Managers\SupplierManager;


class ProductManager extends BaseManager {

    protected $product;


    public function save()
    {
        $data = $this->data;

        $data['user_id'] = \Auth::user()->id;

        $canCreateSupplier = PermissionRepo::checkAuth('Supplier' , 'Create');

        if(!isset($data['supplier_id']) && isset($data['supplier']) && $canCreateSupplier)
        {
            return $this->saveWithNewSupplier($data);
        }
        else
        {
            return $this->saveWithExistsSupplier($data);
        }

    }

    private function saveWithExistsSupplier($data)
    {

        $ProductValidator = new ProductValidator(new \Product);

        $productValid  =  $ProductValidator->isValid($data);

        if( $productValid )
        {

            $data = $this->prepareData( $data );

            $this->product = new \Product( $data );

            /*$stores = \Store::all();

            $ProductStore = [];

            foreach($stores as $k => $store)
            {
                $ProductStore[$store->id]['quantity'] = 0;
            }

            $data['ProductStore'] = ( !empty($data['ProductStore']) ? $data['ProductStore'] : [] ) + $ProductStore ;*/

            $this->product->save();

            //$this->product->stores()->sync($data['ProductStore']);

            $this->product->segments()->sync($data['SegmentProduct']);

            $product_return = \Product::with([ 'user' , 'supplier' , 'segments'])->where('id' , $this->product->id)->first();

            $response = [
                'success' => true,
                'product' => $product_return
            ];

        }
        else
        {

            $productErrors = [];

            if($ProductValidator->getErrors())
                $productErrors = $ProductValidator->getErrors()->toArray();

            $errors =  $productErrors;

             $response = [
                'success' => false,
                'errors' => $errors,
                'newSupplier' => 0,
                'supplierSelectedId' => ((isset($data['supplier_id'])) ? $data['supplier_id']: '')
            ];
        }

        return $response;
    }

    private function saveWithNewSupplier($data)
    {

        $createSupplier = new SupplierManager( $data['supplier'] );

        $responseSupplier = $createSupplier->save();

        if(isset($responseSupplier['return_id']))
        {
            $data['supplier_id'] = $responseSupplier['return_id'];
        }

        $ProductValidator = new ProductValidator(new \Product);

        $productValid  =  $ProductValidator->isValid($data);

        if( $productValid )
        {

            $data = $this->prepareData( $data );

            $this->product = new \Product( $data );

            /*$stores = \Store::all();

            $ProductStore = [];

            foreach($stores as $k => $store)
            {
                $ProductStore[$store->id]['quantity'] = 0;
            }

            $data['ProductStore'] = $data['ProductStore'] + $ProductStore ;*/

            $this->product->save();

            $this->product->segments()->sync($data['SegmentProduct']);

            //$this->product->stores()->sync($data['ProductStore']);

            $responseProduct = [
                'success' => true,
                'product' => $this->product
            ];

        }
        else
        {

            $productErrors = [];

            if($ProductValidator->getErrors())
                $productErrors = $ProductValidator->getErrors()->toArray();

            $errors =  $productErrors;

            $responseProduct = [
                'success' => false,
                'errors' => $errors
            ];
        }

        if($responseSupplier['success'] && $responseProduct['success'])
        {
            $response = [
                'success' => true,
                'product' => $this->product
            ];
        }
        else
        {
            if(isset($responseSupplier['errors']))
            {
                foreach($responseSupplier['errors'] as $k => $e)
                {

                    $responseSupplier['errors']['supplier.'.$k] = $e;

                    unset($responseSupplier['errors'][$k]);

                }
            }

            $errors = ( (isset( $responseSupplier['errors'] ) ) ? $responseSupplier['errors'] : [] )

                    + ( (isset( $responseProduct['errors'] ) ) ? $responseProduct['errors'] : [] );

            $response = [
                'success' => false,
                'errors' => $errors,
                'newSupplier' => true,
                'supplierSelectedId' => 0
            ];
        }

        return $response;

    }

    public function update()
    {
        $data = $this->data;

        $data['user_id'] = \Auth::user()->id;

        $canCreateSupplier = PermissionRepo::checkAuth('Supplier' , 'Create');

        if(!isset($data['supplier_id']) && isset($data['supplier']) && $canCreateSupplier)
        {
            return $this->updateWithNewSupplier($data);
        }
        else
        {
            return $this->updateWithExistsSupplier($data);
        }

    }

    private function updateWithExistsSupplier($data)
    {
        $this->product = \Product::find($data['id']);

        $ProductValidator = new ProductValidator($this->product);

        $productValid  =  $ProductValidator->isValid($data);

        if( $productValid )
        {

            $data = $this->prepareData( $data );

            $product = $this->product;

            $product->name = $data['name'];

            $product->key = $data['key'];

            $product->model = $data['model'];

            $product->description = $data['description'];

            $product->stock = $data['stock'];

            $product->image = $data['image'];

            $product->price = $data['price'];

            $product->percent_gain = $data['percent_gain'];

            $product->cost = $data['cost'];

            $product->status = $data['status'];

            $product->production_days = $data['production_days'];

            $product->supplier_id = $data['supplier_id'];

            $product->user_id = $data['user_id'];
            /*$ProductStore = [];

            foreach($product->stores as $k => $store)
            {
                $ProductStore[$store->id]['quantity'] = $store->pivot->quantity;
            }

            $data['ProductStore'] = $data['ProductStore'] + $ProductStore ;*/

            $this->product->save();

            $this->product->segments()->sync($data['SegmentProduct']);

            //$this->product->stores()->sync($data['ProductStore']);

            $response = [
                'success' => true
            ];

        }
        else
        {

            $productErrors = [];

            if($ProductValidator->getErrors())
                $productErrors = $ProductValidator->getErrors()->toArray();

            $errors =  $productErrors;

             $response = [
                'success' => false,
                'errors' => $errors,
                'newSupplier' => 0,
                'supplierSelectedId' => ((isset($data['supplier_id'])) ? $data['supplier_id'] : '' )
            ];
        }

        return $response;
    }

    private function updateWithNewSupplier($data)
    {
        $this->product = \Product::find($data['id']);

        $createSupplier = new SupplierManager( $data['supplier'] );

        $responseSupplier = $createSupplier->save();

        if(isset($responseSupplier['return_id']))
        {
            $data['supplier_id'] = $responseSupplier['return_id'];
        }

        $ProductValidator = new ProductValidator(new \Product);

        $productValid  =  $ProductValidator->isValid($data);

        if( $productValid )
        {

            $data = $this->prepareData( $data );

            $product = $this->product;

            $product->name = $data['name'];

            $product->key = $data['key'];

            $product->model = $data['model'];

            $product->description = $data['description'];

            $product->stock = $data['stock'];

            $product->image = $data['image'];

            $product->price = $data['price'];

            $product->cost = $data['cost'];

            $product->status = $data['status'];

            $product->production_days = $data['production_days'];

            $product->supplier_id = $data['supplier_id'];

            $product->user_id = $data['user_id'];

            $userData = $this->data;

            /*$ProductStore = [];

            foreach($product->stores as $k => $store)
            {
                $ProductStore[$store->id]['quantity'] = $store->pivot->quantity;
            }

            $data['ProductStore'] = $data['ProductStore'] + $ProductStore ;*/

            $this->product->save();

            $this->product->segments()->sync($data['SegmentProduct']);

            //$this->product->stores()->sync($data['ProductStore']);

            $responseProduct = [
                'success' => true
            ];

        }
        else
        {

            $productErrors = [];

            if($ProductValidator->getErrors())
                $productErrors = $ProductValidator->getErrors()->toArray();

            $errors =  $productErrors;

            $responseProduct = [
                'success' => false,
                'errors' => $errors
            ];
        }

        if($responseSupplier['success'] && $responseProduct['success'])
        {
            $response = [
                'success' => true
            ];
        }
        else
        {
            if(isset($responseSupplier['errors']))
            {
                foreach($responseSupplier['errors'] as $k => $e)
                {

                    $responseSupplier['errors']['supplier.'.$k] = $e;

                    unset($responseSupplier['errors'][$k]);

                }
            }

            $errors = ( (isset( $responseSupplier['errors'] ) ) ? $responseSupplier['errors'] : [] )

                    + ( (isset( $responseProduct['errors'] ) ) ? $responseProduct['errors'] : [] );

            $response = [
                'success' => false,
                'errors' => $errors,
                'newSupplier' => true,
                'supplierSelectedId' => 0
            ];
        }

        return $response;

    }

    public function destroy()
    {

        $userData = $this->data;

        $this->user = \User::find($userData['id']);

        $user = $this->user;

        $user->status_system = 0;

        if( $user->save() )
        {
            $response = [
                'success' => true
            ];
        }else
        {
            $response = [
                'success' => false,
                'errors' => 'No se pudo eliminar el usuario.'
            ];

        }

        return $response;

    }

    public function saveImage()
    {

        $data = $this->data;

        $filename = time(). '.' .$data['image']->getClientOriginalExtension();



        if($data['image']->move('images_products', $filename))
        {
            $response = [
                'success' => true,
                'error' => '',
                'filename' => $filename,
                'path' => asset('/images_products/')
            ];
        }
        else
        {
            $response = [
                'success' => false,
                'error' => '',
            ];
        }

        return $response;

    }

    public function prepareData($data)
    {

        if(!isset($data['status']))
        {
            $data['status'] = false;
        }

        if(!isset($data['stock']))
        {
            $data['stock'] = 0;
        }

        if(isset($data['image']))
        {
            if(!is_object($data['image']))
            {

            }else
            {
                $filename = \Str::slug($data['key']). '_' . time(). '.' .$data['image']->getClientOriginalExtension();

                if($data['image']->move('images_products', $filename))
                {
                    $data['image'] = $filename;
                }

            }
        }else
        {
            if(isset($this->product->id))
            {
                $data['image'] = $this->product->image;
            }
        }

        if(!isset($data['SegmentProduct']))
        {
            $data['SegmentProduct'] = [];
        }

        return $data;


    }

    public function addStock($quantity = 0 , $store_id = false)
    {

        $productData = $this->data;

        $this->product = \Product::with(['stores'])->find($productData['id']);

        if($store_id)
        {

            $store = $this->product->stores->find($store_id);

            if($store)
            {

                $quantityOld = $store->pivot->quantity;

                $attributes = [

                    'quantity' => $quantityOld + $quantity

                ];

                $this->product->stores()->updateExistingPivot($store_id, $attributes);

            }

        }
        else
        {
            $quantityOld = $this->product->stock;

            $this->product->stock = $quantityOld + $quantity;

            $this->product->update();


        }
    }

}