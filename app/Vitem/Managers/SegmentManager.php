<?php namespace Vitem\Managers;

use Vitem\Validators\SegmentValidator;


class SegmentManager extends BaseManager {

    protected $segment;

    
    public function save()
    {
        $SegmentValidator = new SegmentValidator(new \Segment);

        $segmentData = $this->data; 

        $segmentData = $this->prepareData($segmentData);

        $segmentValid  =  $SegmentValidator->isValid($segmentData);

        if( $segmentValid )
        {

            if(!empty($segmentData['id']))
            {
                $segment = \Segment::find($segmentData['id']);

                if($segment)
                {
                    unset($segmentData['id']);

                    $segment->update($segmentData);
                }

            }
            else
            {
                $segment = new \Segment( $segmentData ); 
            
                $segment->save(); 

            }

            $segment->catalog_items()->sync($segmentData['CatalogItem']);
            
            

            $response = [
                'success' => true,
                'return_id' => $segment->id,
                'segment' => \Segment::with('catalog_items.catalog.items')->find($segment->id)
            ];            

        }
        else
        {
            
            $segmentErrors = [];

            if($SegmentValidator->getErrors())
                $segmentErrors = $SegmentValidator->getErrors()->toArray();            

            $errors =  $segmentErrors;

             $response = [
                'success' => false,
                'errors' => $errors
            ];
        }

        return $response;

    }

    public function update()
    {
    }

    public function delete()
    {

        

    }

    public function prepareData($segmentData)
    {
        
        $segmentData['user_id'] = \Auth::user()->id;

        $segmentData['slug'] = \Str::slug($segmentData['name']);

        return $segmentData;
    }

} 

