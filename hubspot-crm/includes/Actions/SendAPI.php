<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Action_SendAPI
 */
final class NF_Action_NinjaAPI extends NF_Abstracts_Action
{
    /**
     * @var string
     */
    protected $_name  = 'ninja_api';

    protected $cookie_name = 'dns_pages';

    /**
     * @var array
     */
    protected $_tags = array();

    /**
     * @var string
     */
    protected $_timing = 'normal';

    /**
     * @var array
     */
    protected $api_field = array('firstname',
		'email',
		'phone',
		'message',
	);

    /**
     * @var array
     */
    protected $analitis_field = array(
    	'page_first',
		'page_total',
		'page_last',
		'pip',
	);

    /**
     * @var array
     */
    protected $gmt_field = array(
    	'utm_campaign',
    	'utm_medium',
    	'utm_source',
    	'camp',
    	'group',
		'key',
    	'adposition',
    	'device',
    	'network',
    	'matchtype',
    	'loc_physical_ms',
		'gclid',
		'keyword',
		'placement');

    /**
     * @var int
     */
    protected $_priority = 10;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'HubSpot CRM API', '' );

        /*
	     * All Settings
	     */

	    $data_field = array(
		    'hapikey' => array(
		        'name' => 'hapikey',
		        'type' => 'textbox',
		        'label' => __( 'Hapikey', ''),
		        'width' => 'full',
		        'group' => 'primary',
		        'value' => '',
		        'placeholder' => __( 'Hapikey' ),
		        'help' => __( 'Hapikey (ex:4854a967-4d43-4afa-be1e-9bee70688063).', '' ),
		    ),

		    'firstname' => array(
		        'name' => 'firstname',
		        'type' => 'textbox',
		        'label' => __( 'Họ và tên', ''),
		        'width' => 'full',
		        'group' => 'primary',
		        'use_merge_tags' => true,
		        'value' => '',
		        'placeholder' => __( 'Chọn trường cần hiển thị' ),
		        'help' => __( '.', '' ),
		    ),

		    'email' => array(
		        'name' => 'email',
		        'type' => 'textbox',
		        'label' => __( 'Email', ''),
		        'width' => 'full',
		        'group' => 'primary',
		        'use_merge_tags' => true,
		        'value' => '',
		        'placeholder' => __( 'Chọn trường cần hiển thị' ),
		        'help' => __( '.', '' ),
		    ),

		    'phone' => array(
		        'name' => 'phone',
		        'type' => 'textbox',
		        'label' => __( 'Điện Thoại', ''),
		        'width' => 'full',
		        'group' => 'primary',
		        'use_merge_tags' => true,
		        'value' => '',
		        'placeholder' => __( 'Chọn trường cần hiển thị' ),
		        'help' => __( '.', '' ),
		    ),
		    'message' => array(
		        'name' => 'message',
		        'type' => 'textbox',
		        'label' => __( 'Thông tin mô tả', ''),
		        'width' => 'full',
		        'group' => 'primary',
		        'use_merge_tags' => true,
		        'value' => '',
		        'placeholder' => __( 'Chọn trường cần hiển thị' ),
		        'help' => __( '.', '' ),
		    ),
		 
		);    
		$this->_settings = $data_field;
	}


    public function save( $action_settings ){}

    /*
	* Process after submit
    */
    public function process( $action_settings, $form_id, $data )
    {
    	
        if(trim($action_settings['hapikey']) == '' ) return $data;
    	
        $data_send = array(array('property' => 'lastname','value' => ''));

        foreach ($this->api_field as $field) {
        	$val = $action_settings[$field];
        	if ($field == 'email' && $action_settings[$field] =='') {
        		$val = 'email'.rand().'@mail.com';
        	}
        	if (trim($val) != '') {
        		$data_send[] = array(
                    'property' => trim($field),
                    'value' =>$val
	            );
        	}
        }
        if(!session_id()) {
	        session_start();
	    }
	    foreach ($this->gmt_field as $gfield) {
	    	$val = $_SESSION['gmt_data'][$gfield];
        	if (trim($val) != '') {
        		$data_send[] = array(
                    'property' => trim($gfield),
                    'value' =>$val
	            );
        	}	
	    }
	   	

	    if (isset($_COOKIE[$this->cookie_name])) {
	    	$vcookie = stripslashes($_COOKIE[$this->cookie_name]);
    		$vcookie = json_decode($vcookie,true);
	    	foreach ($this->analitis_field as $afield) {
	    		if (isset($vcookie[$afield]) && $vcookie[$afield] != '') {
	    			$data_send[] = array(
	                    'property' => trim($afield),
	                    'value' =>$vcookie[$afield]
		            );
	    		}
	    	}
	    	unset($_COOKIE[$this->cookie_name]);
	    }

        $arr = array( 'properties' => $data_send);
        $post_json = json_encode($arr);

        $hapikey = trim($action_settings['hapikey']);
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey=' . $hapikey;
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
        return $data;
    }
}