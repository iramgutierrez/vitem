<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Explode Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Isaac Raway
 * @link		
 */

$plugin_info = array(
    'pi_name'		=> 'Expedia',
    'pi_version'	=> '1.0',
    'pi_author'		=> 'Isaac Raway',
    'pi_author_url'	=> '',
    'pi_description'=> 'Splits a string',
    'pi_usage'		=> Expedia::usage()
);


class Expedia {

    public $return_data;
    
    public function __construct()
    {
        $this->EE =& get_instance();
        
        $p_string = $this->EE->TMPL->fetch_param('string');
        $p_separator = $this->EE->TMPL->fetch_param('separator');
        $p_loop = $this->EE->TMPL->fetch_param('loop', 'yes') == 'yes';
        
        $items = explode($p_separator, $p_string);
        $rows = array();
        $count = 0;
        $total_count = count($items);
        
        if($p_loop)
        {
            foreach($items as $item)
            {
                $count++;
                $rows[] = array(
                    'exp_value' => $item,
                    'exp_count' => $count,
                    'exp_total_count' => $total_count
                );
            }
        } else {
            $rows = array(array('exp_total_count' => $total_count));
            foreach($items as $item)
            {
                $count++;
                $rows[0]['exp_value_'.$count] = $item;
            }
        }
        
        $this->return_data = $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $rows);
    }
    
    public static function usage()
    {
        ob_start();
?>
Expedia API

{exp:explode separator=":" string="value : Label" loop="no"}
    <a href="{path='products/{exp_value_1}'}">{exp_value_2}</a>
{/exp:explode}
<?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
}


/* End of file pi.explode.php */
/* Location: /system/expressionengine/third_party/explode/pi.explode.php */
