<?php
class FloatWDTColumn extends WDTColumn {

    protected $_jsDataType = 'formatted-num';
    protected $_dataType = 'float';
    
    public function __construct( $properties = array () ) {
		parent::__construct( $properties );
		$this->dataType = 'float';
		$this->_jsFilterType = 'number';
		$this->addCSSClass('numdata');
    }
    
    public function prepareCellOutput( $content ) {
    	
		$number_format = get_option('wdtNumberFormat') ? get_option('wdtNumberFormat') : 1;
		$decimal_places = get_option('wdtDecimalPlaces') !== false ? get_option('wdtDecimalPlaces') : 2;
		
		if($number_format == 1){
			$formattedValue = number_format( (float) $content, $decimal_places, ',', '.');
		}else{
			$formattedValue = number_format( (float) $content, $decimal_places, '.', ',');
		}
    	
		$formattedValue = apply_filters( 'wpdatatables_filter_float_cell', $formattedValue );
		return $formattedValue;
    }
    
    public function getGoogleChartColumnType(){
        return 'number';
    }    
    
}


?>