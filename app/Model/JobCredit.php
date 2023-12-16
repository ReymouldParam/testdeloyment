<?php

/**
 * @abstract This model class is written for Category Model for this project
 * @Package MOdel
 * @category Model
 * @author Logicspice(info@logicspice.com)
 * @since 1.0.0 2015-07-22
 * @copyright Copyright & Copy ; 2015, Logicspice Consultancy Pvt. Ltd., Jaipur
 *
 */
class JobCredit extends AppModel {

    public $name = 'JobCredit';
	var $belongsTo = array(
        'Job' => array(
            'className' => 'Job',
            'foreignKey' => 'job_id',
           'fields' => array('id', 'title','slug')
        ),
    );

}

?>