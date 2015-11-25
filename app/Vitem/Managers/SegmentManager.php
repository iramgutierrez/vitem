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

        $new = false;

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

                $values = [];

                $ids = '';

                foreach($segmentData['CatalogItem'] as $item)
                {
                    if($ids != '')
                    {
                        $ids.=',';
                    }
                    $ids.=$item;
                }

                $values[] = $ids;

                $values[] = count($segmentData['CatalogItem']);

                $exists =  \DB::select("SELECT segment_id,count(*) as count FROM segment_catalog_item WHERE catalog_item_id in (".$ids.") GROUP BY segment_id HAVING count(*) = ".count($segmentData['CatalogItem']));

                if(count($exists))
                {
                    $segment = \Segment::find($exists[0]->segment_id);
                }
                else
                {
                    $segment = new \Segment( $segmentData );

                    $segment->save();

                    $new = true;
                }



            }

            $segment->catalog_items()->sync($segmentData['CatalogItem']);

            $response = [
                'success' => true,
                'return_id' => $segment->id,
                'segment' => \Segment::with('catalog_items.catalog.items')->find($segment->id),
                'new' => $new
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

        $segmentData['name'] = (!empty($segmentData['name'])) ? $segmentData['name'] : '';

        $segmentData['slug'] = \Str::slug($segmentData['name']);

        return $segmentData;
    }

} 

