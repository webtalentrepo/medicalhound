<?php
/**
 * Main engine of wpDataTables plugin
 */

class WPDataTable {
    
    private $scriptsEnabled = true;
    private $_wdtIndexedColumns = array( );
    private $_wdtNamedColumns = array( );
    private $_defaultSortColumn = null;
    private $_defaultSortDirection = 'ASC';	
    private $_title = '';
    private $_interfaceLanguage;    
    private $_responsive = false;         
    private $_no_data = false;
    private $_filtering_form = false;
    private $_hide_before_load = false;       
    public static $wdt_internal_idcount = 0;
    private $_horAxisCol = '';
    private $_verAxisCol = '';
    private $_chartType = '';
    private $_chartTitle = '';
    public static $mc = null;
    private $_fromCache = false;
    private $_pagination = true;
    private $_showFilter = true;
    private $_firstOnPage = false;
    private $_groupingEnabled = false;
    private $_wdtColumnGroupIndex = 0;
    private $_showAdvancedFilter = false;
    private $_wdtTableSort = true;
    private $_serverProcessing = false;
    private $_wdtColumnTypes = array( );
    private $_dataRows = array( );
    public  $_cacheHash = '';
    private $_showTT = true;
    private $_lengthDisplay = 10;
    private $_cssClassArray = array( );
    private $_style	 = '';
    private $_chartSeriesArr = array();
    private $_editable = false;
    private $_id = '';
    private $_idColumnKey = '';
    private $_db;
    private $_wpId = '';
    private $_onlyOwnRows = false;
    private $_userIdColumn = 0;

    public function setNoData($no_data){
       $this->_no_data = $no_data;
    }

    public function getNoData(){
        return $this->_no_data;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId( $id ) {
        $this->_id = $id;
    }
    
    public function sortEnabled() {
        return $this->_wdtTableSort;
    }
    
    public function sortEnable() {
	$this->_wdtTableSort = true;
    }
    
    public function sortDisable() {
        $this->_wdtTableSort = false;
    }
    
    public function reorderColumns( $posArray ) {
     	if( !is_array( $posArray )){
     		throw new WDTException('Invalid position data provided!');
     	}
     	$resultArray = array();
     	$resultByKeys = array();
        
     	foreach( $posArray as $pos=>$dataColumnIndex ){
     		$resultArray[$pos] = $this->_wdtNamedColumns[$dataColumnIndex];
     		$resultByKeys[$dataColumnIndex] = $this->_wdtNamedColumns[$dataColumnIndex];
     	}
     	$this->_wdtIndexedColumns = $resultArray;
     	$this->_wdtNamedColumns = $resultByKeys;
    }    

    public function getWpId() {
        return $this->_wpId;
    }

    public function setWpId( $wpId ) {
        $this->_wpId = $wpId;
    }

    public function getCssClassesArr(){
        $classesStr = $this->_cssClassArray;
        $classesStr = apply_filters( 'wpdatatables_filter_table_cssClassArray', $classesStr, $this->getWpId() );
        return $classesStr;
    }
    
    public function getCSSClasses(){
        return implode(' ', $this->_cssClassArray);
    }

    public function addCSSClass( $cssClass ) {
        $this->_cssClassArray[] = $cssClass;
    }

    public function getCSSStyle() {
        return $this->_style;
    }

    public function setCSSStyle( $style ){
        $this->_style = $style;
    }

    public function setTitle( $title ) {
        $this->_title = $title;
    }

    public function getName(){
        return $this->_title;
    }

    public function enableServerProcessing(){
       $this->_serverProcessing = true;
    }

    public function disableServerProcessing(){
       $this->_serverProcessing = false;
    }
      
    public function serverSide(){
      return $this->_serverProcessing;
    }
       
    public function setResponsive($responsive){
         if($responsive){
            $this->_responsive = true;
         }else{
            $this->_responisive = false;
         }
    }
       
    public function isResponsive(){
      return $this->_responsive;
    }
     
    public function setInterfaceLanguage( $lang ) {
       if( empty($lang) ){
               throw new WDTException('Incorrect language parameter!');
       }
       if( !file_exists( WDT_ROOT_PATH.'source/lang/'.$lang ) ){
               throw new WDTException('Language file not found');
       }
       $this->_interfaceLanguage = WDT_ROOT_PATH.'source/lang/'.$lang;
    }
     
    public function getInterfaceLanguage(){
      return $this->_interfaceLanguage;
    }
	
    public function paginationEnabled() {
        return $this->_pagination;
    }
    
    public function enablePagination() {
        $this->_pagination = true;
    }
    
    public function disablePagination() {
        $this->_pagination = false;
    }    
    
    public function enableTT() {
        $this->_showTT = true;
    }
	
    public function disableTT() {
        $this->_showTT = false;
    }

    public function TTEnabled() {
        return $this->_showTT;
    }
    
    public function hideToolbar() {
        $this->_toolbar = false;
    }
    
    public function setDefaultSortColumn( $key ){
        if( !isset( $this->_wdtIndexedColumns[$key] ) 
                && !isset( $this->_wdtNamedColumns[$key] ) ) {
            throw new WDTException( 'Incorrect column index' );
        }

        if(!is_numeric($key)){
            $key = array_search( $key, array_keys($this->_wdtNamedColumns) );
        }
        $this->_defaultSortColumn = $key;
    }
	
    public function getDefaultSortColumn(){
        return $this->_defaultSortColumn;
    }
    
    public function setDefaultSortDirection($direction){
     	if( 
                !in_array( 
                        $direction, 
                        array( 
                            'ASC',
                            'DESC' 
                            ) 
                        ) 
                ){ 
            return false; 
        }
     	$this->_defaultSortDirection = $direction;
    }
     
    public function getDefaultSortDirection(){
      	return $this->_defaultSortDirection;
    }

    public function enableEditing(){
     	$this->_editable = true;
    }
     
    public function disableEditing(){
     	$this->_editable = false;
    }
     
    public function isEditable(){
      	return $this->_editable;
    }
      
    public function hideBeforeLoad(){
        $this->setCSSStyle('display: none; ');
        $this->_hide_before_load = true;
    }
      
    public function showBeforeLoad(){
        $this->_hide_before_load = false;
    }
       
    public function doHideBeforeLoad(){
        return $this->_hide_before_load;
    }
	
    public function getDisplayLength(){
        return $this->_lengthDisplay;
    }
	
    public function setDisplayLength( $length ){
            if(!in_array($length, array(5, 10, 20, 25, 30, 50, 100, 200, -1))){
                    return false;
            }		
            $this->_lengthDisplay = $length;
    }
    
    public function setIdColumnKey( $key ) {
     	$this->_idColumnKey = $key;
    }
     
    public function getIdColumnKey(){
      	return $this->_idColumnKey;
    }
    
    public function __construct( ) {
        // connect to MySQL if enabled
        if(WDT_ENABLE_MYSQL && get_option('wdtUseSeparateCon')){
            $this->_db = new PDTSql(WDT_MYSQL_HOST, WDT_MYSQL_DB, WDT_MYSQL_USER, WDT_MYSQL_PASSWORD);
        }
        if(self::$wdt_internal_idcount == 0){ $this->_firstOnPage = true; }
        self::$wdt_internal_idcount++;
        $this->_id = 'table_'.self::$wdt_internal_idcount;
    }    
    
    public function wdtDefineColumnsWidth( $widthsArray ) {
        if( empty( $this->_wdtIndexedColumns ) ) { throw new WDTException('wpDataTable reports no columns are defined!'); }
        if( !is_array($widthsArray) ) { throw new WDTException('Incorrect parameter passed!'); }
        if( wdtTools::isArrayAssoc($widthsArray) ) {
            foreach( $widthsArray as  $name =>$value ) {
                if(!isset($this->_wdtNamedColumns[ $name ])) { continue; }
                $this->_wdtNamedColumns[ $name ]->setWidth($value);
            }
        } else{
            // if width is provided in indexed array
            foreach( $widthsArray as  $name =>$value ) {
                $this->_wdtIndexedColumns[ $name ]->setWidth($value);
            }
        }
    }
    
    public function setColumnsPossibleValues( $valuesArray ) {
        if( empty($this->_wdtIndexedColumns) ) {
                throw new WDTException('No columns in the table!');
        }
        if( !is_array( $valuesArray ) ) {
            throw new WDTException('Valid array of width values is required!');
        }
        if( WDTTools::isArrayAssoc( $valuesArray ) ) {
            foreach( $valuesArray as $key=>$value ) {
                if(!isset($this->_wdtNamedColumns[$key])) { continue; }
                $this->_wdtNamedColumns[$key]->setPossibleValues($value);
            }
        } else{
            foreach( $valuesArray as $key=>$value ) {
                $this->_wdtIndexedColumns[$key]->setPossibleValues( $value );
            }
        }
    }    
	
    public function getHiddenColumnCount(){
        $count = 0;
        foreach($this->_wdtIndexedColumns as $dataColumn){
            if(!$dataColumn->isVisible()){
                $count++;
            }
        }
        return $count;
    }
       
    public function filterEnabled() {
        return $this->_showFilter;
    }
    
    public function enableFilter() {
        $this->_showFilter = true;
    }
    
    public function disableFilter() {
        $this->_showFilter = false;
    }    
    
    public function setFilteringForm( $filteringForm ){
    	$this->_filtering_form = (bool) $filteringForm;
    }
    
    public function getFilteringForm(){
    	return $this->_filtering_form;
    }
    
    public function advancedFilterEnabled() {
        return $this->_showAdvancedFilter;
    }
    
    public function enableAdvancedFilter() {
        $this->_showAdvancedFilter = true;
    }
    
    public function disableAdvancedFilter() {
        $this->_showAdvancedFilter = false;
    }    
    
    public function enableGrouping() {
        $this->_groupingEnabled = true;
    }
	
    public function disableGrouping() {
        $this->_groupingEnabled = false;
    }

    public function groupingEnabled() {
        return $this->_groupingEnabled;
    }
	
    public function groupByColumn($key) {
        if( !isset( $this->_wdtIndexedColumns[$key] ) 
                && !isset( $this->_wdtNamedColumns[$key] ) ){
            throw new WDTException('Column not found!');
        }

        if( !is_numeric( $key ) ){
            $key = array_search( 
                        $key, 
                        array_keys( $this->_wdtNamedColumns ) 
                    );
        }
        
        $this->enableGrouping();
        $this->_wdtColumnGroupIndex = $key;
    }

    /**
     * Returns the index of grouping column 
     */
    public function groupingColumnIndex(){
            return $this->_wdtColumnGroupIndex;
    }

    /**
     * Returns the grouping column index
     */
    public function groupingColumn(){
        return $this->_wdtColumnGroupIndex;
    }
	
    public function countColumns() {
	return count( $this->_wdtIndexedColumns );
    }
    
    public function getColumnKeys() {
        return array_keys( $this->_wdtNamedColumns );
    }
    
    public function setOnlyOwnRows( $ownRows ){
        $this->_onlyOwnRows = (bool) $ownRows;
    }
    
    public function getOnlyOwnRows(){
        return $this->_onlyOwnRows;
    }
    
    public function setUserIdColumn( $column ){
        $this->_userIdColumn = $column;
    }
    
    public function getUserIdColumn(){
        return $this->_userIdColumn;
    }
    
    public function getColumns() {
        return $this->_wdtIndexedColumns;
    }
    
    public function getColumnsByHeaders() {
        return $this->_wdtNamedColumns;
    }
    
    public function createColumnsFromArr( $headerArr, $wdtParameters, $wdtColumnTypes ){
        
        foreach($headerArr as $key) {
            $dataColumnProperties = array( );
            $dataColumnProperties['title']	= isset($wdtParameters['column_titles'][$key]) ? $wdtParameters['column_titles'][$key] : $key;
            $dataColumnProperties['width']	= !empty($wdtParameters['columns_width'][$key]) ? $wdtParameters['columns_width'][$key] : '';
            $dataColumnProperties['sort'] = $this->_wdtTableSort;
            $dataColumnProperties['orig_header'] = $key;
            $dataColumn = WDTColumn::generateColumn( $wdtColumnTypes[$key], $dataColumnProperties );
            $this->_wdtIndexedColumns[] = $dataColumn;
            $this->_wdtNamedColumns[$key] = &$this->_wdtIndexedColumns[count($this->_wdtIndexedColumns)-1];
        }        
        
    } 
    
    public function getColumnHeaderOffset($key){
     	$keys = $this->getColumnKeys();
     	if(!empty($key) && in_array($key, $keys)){
            return array_search($key, $keys);
     	}else{
            return -1;
     	}
    }
		
    public function getColumnDefinitions() {
        $defs = array();
        foreach($this->_wdtIndexedColumns as $key => &$dataColumn){
            $def = $dataColumn->getColumnJSON();
            $def->aTargets = array($key);
            $defs[] = json_encode($def);
        }
        return implode(', ', $defs);
    }
    
    public function getColumnFilterDefs() {
        $defs = array();
         foreach($this->_wdtIndexedColumns as $key=>$dataColumn){
            $def = $dataColumn->getFilterType();
            if($this->getFilteringForm()){
                $def->sSelector = '#'.$this->getId().'_'.$key.'_filter';
            }
                $def->defaultValue = $dataColumn->getDefaultValue(); 
            $defs[] = json_encode($def);
        }
        return implode(', ', $defs);    	
    }
    
    public function getColumn( $dataColumnIndex ) {
        if( !isset( $dataColumnIndex ) 
                || ( !isset($this->_wdtNamedColumns[$dataColumnIndex])
                && !isset($this->_wdtIndexedColumns[$dataColumnIndex]) ) ) {
                        return false;
        }
        if( !is_int( $dataColumnIndex ) ){
            return $this->_wdtNamedColumns[$dataColumnIndex];
        } else {
            return $this->_wdtIndexedColumns[$dataColumnIndex];
        }
    }

    public function arrayBasedConstruct( $rawDataArr, $wdtParameters ) {

        if( empty( $rawDataArr ) ){
            if(!isset($wdtParameters['data_types'])){
                $rawDataArr = array(0 => array('No data' => 'No data'));
            }else{
                $arrayEntry = array();
                foreach($wdtParameters['data_types'] as $cKey=>$cType){
                    $arrayEntry[$cKey] = $cKey;
                }
                $rawDataArr[] = $arrayEntry;
            }
            $this->setNoData(true);
        }
        
        $headerArr = WDTTools::extractHeaders( $rawDataArr );

        $wdtColumnTypes = isset($wdtParameters['data_types']) ? $wdtParameters['data_types'] : array( );
        
        if( empty( $wdtColumnTypes ) ){
            $wdtColumnTypes = WDTTools::detectColumnDataTypes( $rawDataArr, $headerArr );
        }

        if( empty( $wdtColumnTypes ) ) {
            foreach( $headerArr as $key ){ $wdtColumnTypes[$key] = 'string'; }
        }

        $this->createColumnsFromArr( $headerArr, $wdtParameters, $wdtColumnTypes );

        $this->_wdtColumnTypes = $wdtColumnTypes;

        if(!$this->getNoData()){ $this->_dataRows = $rawDataArr; }
        
        return true;

    }    
    
    public function hideColumn( $dataColumnIndex ) {
        if( !isset($dataColumnIndex) 
                || !isset($this->_wdtNamedColumns[$dataColumnIndex]) ) {
            throw new WDTException('A column with provided header does not exist.');
        }
        $this->_wdtNamedColumns[$dataColumnIndex]->hide();
    }

    public function showColumn( $dataColumnIndex ) {
        if( !isset($dataColumnIndex) 
                || !isset($this->_wdtNamedColumns[$dataColumnIndex]) ) {
            throw new WDTException('A column with provided header does not exist.');
        }
        $this->_wdtNamedColumns[$dataColumnIndex]->show();
    }

    
    public function getCell( $dataColumnIndex, $rowKey ) {
        if( !isset( $dataColumnIndex ) 
            || !isset( $rowKey ) ) {
                throw new WDTException('Please provide the column key and the row key');
        }
        if( !isset( $this->_dataRows[$rowKey]) ) {
            throw new WDTException('Row does not exist.');
        }
        if( !isset( $this->_wdtNamedColumns[$dataColumnIndex]) 
                && !isset( $this->_wdtIndexedColumns[$dataColumnIndex] ) ) {
            throw new WDTException('Column does not exist.');
        }
        return $this->_dataRows[$rowKey][$dataColumnIndex];
    }
    
    public function returnCellValue( $cellContent, $wdtColumnIndex ) {
        if( !isset($wdtColumnIndex) ) { 
            throw new WDTException('Column index not provided!');
        }
        if( !isset( $this->_wdtNamedColumns[ $wdtColumnIndex ] ) ) {
            throw new WDTException('Column index out of bounds!');
        }
        return $this->_wdtNamedColumns[ $wdtColumnIndex ]->returnCellValue( $cellContent);
    }
    
    public function getDataRows() {
	return $this->_dataRows;
    }
    
    public function getRow( $index ) {
        if( !isset($index) || !isset($this->_dataRows[$index]) ) {
            throw new WDTException('Invalid row index!');
        }
        $rowArray = &$this->_dataRows[$index];
        apply_filters( 'wdt_get_row', $rowArray );
        return $rowArray;
    }
    
    public function addDataColumn( &$dataColumn ) {
        if( !($dataColumn instanceof WDTColumn) ) { throw new WDTException('Please provide a wpDataTable column.'); }
        apply_filters( 'wdt_add_column', $dataColumn );
        $this->_wdtIndexedColumns[] = &$dataColumn;
        return true;
    }
    
    public function addColumns( &$dataColumns ) {
        if( !is_array( $dataColumns ) ) { throw new WDTException('Please provide an array of wpDataTable column objects.'); }
        apply_filters( 'wdt_add_columns', $dataColumns );
        foreach( $dataColumns as &$dataColumn ) {
            $this->addDataColumn( $dataColumn );
        }
    }
    
    public function addWDTRow( $row ) {
        if( count( $this->_wdtIndexedColumns ) == 0 ) {
            throw new WDTException('Please add columns to wpDataTable first.');
        }
        if( !( $row instanceof WDTRow ) ) {
            throw new WDTException( 'Please provide a proper wpDataTables Row' );
        }
        if( $row->countCells() != $this->countColumns() ) {
            throw new WDTException( 'Count of the columns in table and in row is not equal. Row: '.$row->countCells().', table: '.$this->countColumns() );
        }
        apply_filters( 'wdt_add_row', $row );
        $this->_dataRows[] = &$row;
    }

    public function addRows( &$rows ) {
        if( !is_array( $rows ) ) {
            throw new WDTException('Please provide an array of WDTRow objects.');
        }
        apply_filters( 'wdt_add_dataRows', $rows );
        foreach( $rows as &$row ) {
            $this->addWDTRow( $row );
        }
    }
    
    public function setChartHorizontalAxis($dataColumnIndex){
        if( !isset($dataColumnIndex) || !isset($this->_wdtNamedColumns[$dataColumnIndex]) ) {
            throw new WDTException('Please provide a correct column index.');
        }
        $this->_horAxisCol = $dataColumnIndex;          
    }
    
    public function setChartVerticalAxis($dataColumnIndex){
        // if we are getting the data from cache - just skip the call
        if(self::$mc && $this->_fromCache){
            return false;
        }        
        if( !isset($dataColumnIndex) || !isset($this->_wdtNamedColumns[$dataColumnIndex]) ) {
                throw new WDTException('Invalid columnKey provided!');
        }
        $this->_verAxisCol = $dataColumnIndex;          
    }
    
    public function setChartTitle($title){
        if(empty($title)) { return false; }; 
        $this->_chartTitle = $title;
    }
    
    public function getChartTitle(){
        return $this->_chartTitle;
    }
    
    public function setChartType($type){
        if(empty($type) 
                || ( !in_array( 
                        $type, 
                        array(
                            'Area', 
                            'Bar', 
                            'Column', 
                            'Line', 
                            'Pie'
                        )
                    )
                    )
            ) { 
            throw new WDTException('Invalid chart type provided!'); 
        }; 
        $this->_chartType = $type;
    }
    
    public function getChartType(){
        return $this->_chartType;
    }
    
    public function addChartSeries($dataColumnIndex){
        if( !isset($dataColumnIndex) || !isset($this->_wdtNamedColumns[$dataColumnIndex]) ) {
                throw new WDTException('Invalid columnKey provided!');
        }
        $this->_chartSeriesArr[] = $dataColumnIndex;
    }

    public function disableScripts(){
     	$this->scriptsEnabled = false;
    }
     
    public function scriptsEnabled(){
      	return $this->scriptsEnabled;
    }
    
    public function queryBasedConstruct( $query, $queryParams = array(), $wdtParameters = array (), $init_read = false ) {
        global $wdt_var1, $wdt_var2, $wdt_var3, $wpdb;
        
        // Sanitizing query
        $query = wpdatatables_sanitize_query( $query );
        $query = str_replace( '`', '', $query );
		       	
       	// Placeholders
       	if (strpos( $query, '%CURRENT_USER_ID%' ) !== false ){
            $wdt_cur_user_id = isset( $_POST['current_user_placeholder'] ) ?
                    $_POST['current_user_placeholder'] : get_current_user_id();
            
            $query = str_replace( '%CURRENT_USER_ID%', $wdt_cur_user_id, $query );
       	}
       	if( strpos( $query, '%WPDB%' ) !== false ){
            $query = str_replace( '%WPDB%', $wpdb->prefix, $query );
       	}
        
     	// Shortcode VAR1
     	if(strpos($query, '%VAR1%') !== false){
            $query = str_replace('%VAR1%', $wdt_var1, $query);
     	}
     	
     	// Shortcode VAR2
     	if(strpos($query, '%VAR2%') !== false){
            $query = str_replace('%VAR2%', $wdt_var2, $query);
     	}
     	
     	// Shortcode VAR3
     	if(strpos($query, '%VAR3%') !== false){
            $query = str_replace('%VAR3%', $wdt_var3, $query);
     	}
        
        // Adding limits if necessary
        if(!empty($wdtParameters['limit']) 
        	&& (strpos(strtolower($query), 'limit') === false)){
       		$query .= ' LIMIT '.$wdtParameters['limit'];
        }
        
        // Server-side requests
        if($this->serverSide()) {
            
            $query = apply_filters( 'wpdatatables_filter_query_before_limit', $query, $this->getWpId() );
            
            if(!isset($_GET['sEcho'])) {
                $query .= ' LIMIT '.$this->getDisplayLength();
            } else {
                // Server-side params
                $limit = '';
                $orderby = '';
                $search = '';
                $aColumns = array_keys( $wdtParameters['column_titles'] );

                if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
                            $limit = "LIMIT ".addslashes( $_GET['iDisplayStart'] ).", ".
                                addslashes( $_GET['iDisplayLength'] );
                        }        	

                // Adding sort parameters for AJAX if necessary
                if ( isset( $_GET['iSortCol_0'] ) )
                {
                    $orderby = "ORDER BY  ";
                    for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
                    {
                        if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
                        {
                            $orderby .= '`'.$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."`
                                    ".addslashes( $_GET['sSortDir_'.$i] ) .", ";
                        }
                    }

                    $orderby = substr_replace( $orderby, "", -2 );
                    if ( $orderby == "ORDER BY" )
                    {
                        $orderby = "";
                    }
                }      

                // filtering
                if ( $_GET['sSearch'] != "" )
                {
                    $search = " (";
                    for ( $i=0 ; $i<count($aColumns) ; $i++ )
                    {
                            $search .= '`'.$aColumns[$i]."` LIKE '%".addslashes( $_GET['sSearch'] )."%' OR ";
                    }
                    $search = substr_replace( $search, "", -3 );
                    $search .= ')';
                }

                /* Individual column filtering */
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    if ( ($_GET['bSearchable_'.$i] == "true") 
                            && ($_GET['sSearch_'.$i] != '')
                            && ($_GET['sSearch_'.$i] != '~') ){
                        if(!empty($search)){
                                $search .= ' AND ';
                        }
                        switch($wdtParameters['filter_types'][$aColumns[$i]]) {
                            case 'number':
                                $search .= '`'.$aColumns[$i]."` = ".$_GET['sSearch_'.$i]." ";
                                break;
                            case 'number-range':
                                list($left, $right) = explode('~', $_GET['sSearch_'.$i]);
                                if($left !== ''){
                                    $left = (float) $left;
                                    $search .= '`'.$aColumns[$i]."` >= $left ";
                                }
                                if($right !== ''){
                                    $right = (float) $right;
                                    if(!empty($search) && $left !== ''){ $search .= ' AND '; }
                                    $search .= '`'.$aColumns[$i]."` <= $right ";
                                }
                                break;
                            case 'date-range':
                                list( $left, $right ) = explode('~', $_GET['sSearch_'.$i]);
                                $date_format = str_replace('m', '%m', get_option('wdtDateFormat'));
                                $date_format = str_replace('M', '%M', $date_format);
                                $date_format = str_replace('Y', '%Y', $date_format);
                                $date_format = str_replace('y', '%y', $date_format);
                                $date_format = str_replace('d', '%d', $date_format);
                                if( $left && $right ){
                                    $search .= '`'.$aColumns[$i]."` BETWEEN STR_TO_DATE('$left', '$date_format') AND STR_TO_DATE('$right', '$date_format') ";
                                }elseif($left){
                                    $search .= '`'.$aColumns[$i]."` >= STR_TO_DATE('$left', '$date_format') ";
                                }elseif($right){
                                    $search .= '`'.$aColumns[$i]."` <= STR_TO_DATE('$right', '$date_format') ";
                                }
                                break;
                            case 'select':
                                $search .= '`'.$aColumns[$i]."` = '".addslashes($_GET['sSearch_'.$i])."' ";
                                break;
                            case 'checkbox':
                                $checkboxSearches = explode('|',$_GET['sSearch_'.$i]);
                                $j = 0;
                                $search .= " (";
                                foreach($checkboxSearches as $checkboxSearch){
                                    // Trim regex parts
                                    $checkboxSearch = substr( $checkboxSearch, 1, -1 );
                                    if($j > 0){
                                        $search .= " OR ";
                                    }
                                    $search .= '`'.$aColumns[$i]."` = '".addslashes($checkboxSearch)."' ";
                                    $j++;
                                }
                                $search .= ") ";
                                break;
                            case 'text':
                            default:
                                $search .= '`'.$aColumns[$i]."` LIKE '%".addslashes($_GET['sSearch_'.$i])."%' ";
                        }
                    }
                }
                
            }
            
        }
        
        // Add the filtering by user ID column, if requested
        if( $this->_onlyOwnRows ){
            $userIdColumnCondition =  '`'.$this->_userIdColumn.'` = ' . get_current_user_id();
            $whereInsertIndex = count( $query );
            // Detect where to insert the string
            if( false !== stripos( $query, 'WHERE' ) ){
                // If WHERE is already present in the query
                $query = substr_replace( $query, ' '.$userIdColumnCondition.' AND', stripos( $query, 'WHERE' )+5, 0 );
            }else{
                // If WHERE is not present
                if( false !== stripos( $query, 'LIMIT' )  ){
                    // If LIMIT is present
                    $query = substr_replace( $query, ' WHERE '.$userIdColumnCondition.' ', stripos( $query, 'LIMIT' ), 0 );                    
                }else{
                    $query .= " WHERE ".$userIdColumnCondition;
                }
            }
        }
        
        // The serverside return scenario
        if(isset($_GET['action']) && ($_GET['action'] == 'get_wdtable')){
            
	        /**
	         * 1. Forming the query
	         */
	        $query = preg_replace('/SELECT /i', 'SELECT SQL_CALC_FOUND_ROWS ', $query, 1);
	        if( $search ){
                    if( stripos( $query, 'WHERE' ) ){
                        $query = substr_replace( $query, ' '.$search.' AND', stripos( $query, 'WHERE' )+5, 0 );
                    }else{
                        $query .= ' WHERE '.$search;
                    }
	        }
	        $query .= ' '.$orderby;
	        $query .= ' '.$limit;
	        
	        $query = apply_filters( 'wpdatatables_filter_mysql_query', $query, $this->getWpId() );
                
	        /**
	         * 2. Executing the queries
	         */
	        // The main query
                // Prepare query - replace all duplicated spaces, newlines, etc.
                $query = preg_replace( '!\s+!', ' ', $query );
                
                if(get_option('wdtUseSeparateCon')){
                    $main_res_dataRows = $this->_db->getAssoc( $query, $queryParams );
                }else{
                    // querying using the WP driver otherwise
                    $main_res_dataRows = $wpdb->get_results( $query, ARRAY_A );
                }
                // result length after filtering
                if(get_option('wdtUseSeparateCon')){
                    $res_length = $this->_db->getField('SELECT FOUND_ROWS()');
                }else{
                    // querying using the WP driver otherwise
                    $res_length = $wpdb->get_row( 'SELECT FOUND_ROWS()', ARRAY_A );
                    $res_length = $res_length['FOUND_ROWS()'];
                }
                // total data length
                // get the table name
                $table_title = substr( $query, strpos(strtolower($query), 'from')+5);
                $table_title = substr($table_title, 0, strpos($table_title, ' '));
                $table_title = trim($table_title);
                if(get_option('wdtUseSeparateCon')){
                        $total_length_query = 'SELECT COUNT(*) FROM '.$table_title;
                        // If "Only own rows" options is defined, do not count other user's rows
                        if( isset( $userIdColumnCondition ) ){
                            $total_length_query .= ' WHERE '.$userIdColumnCondition;
                        }
                        $total_length = $this->_db->getField( $total_length_query );
                }else{
                        // querying using the WP driver otherwise
                        $total_length_query = 'SELECT COUNT(*) as cnt_total FROM '.$table_title;
                        // If "Only own rows" options is defined, do not count other user's rows
                        if( isset( $userIdColumnCondition ) ){
                            $total_length_query .= ' WHERE '.$userIdColumnCondition;
                        }
                        $total_length = $wpdb->get_row( $total_length_query, ARRAY_A );
                        $total_length = $total_length['cnt_total'];
                }

                /**
                 * 3. Forming the output
                 */
                // base array
                $output = array(
                        "sEcho" => intval($_GET['sEcho']),
                        "iTotalRecords" => $total_length,
                        "iTotalDisplayRecords" => $res_length,
                        "aaData" => array()
                );

                // create the supplementary array of column objects 
                // which we will use for formatting
                $col_objs = array();
                foreach($wdtParameters['data_types'] as $dataColumn_key=>$dataColumn_type){
                    $col_objs[$dataColumn_key] = WDTColumn::generateColumn( $dataColumn_type, array('title' => $wdtParameters['column_titles'][$dataColumn_key]) );
                    $col_objs[$dataColumn_key]->setInputType( $wdtParameters['input_types'][$dataColumn_key] );
                }
                // reformat output array and reorder as user wanted
                if(!empty($main_res_dataRows)){
                        foreach($main_res_dataRows as $res_row){
                            $row = array();
                            foreach($wdtParameters['column_order'] as $dataColumn_key){
                                $row[] = $col_objs[$dataColumn_key]->returnCellValue($res_row[$dataColumn_key]);
                                unset($cell);
                            }
                            $output['aaData'][] = $row;
                        }
                }
                /**
                 * 4. Returning the result
                 */
                return json_encode($output);
        }else{
            
            // Getting the query result
            // getting by own SQL driver if the user wanted a separate connection
            if(get_option('wdtUseSeparateCon')){
                $query = apply_filters( 'wpdatatables_filter_mysql_query', $query, $this->getWpId() );
                $res_dataRows = $this->_db->getAssoc($query, $queryParams);
                $mysql_error = $this->_db->getLastError();
            }else{
                // querying using the WP driver otherwise
                $query = apply_filters( 'wpdatatables_filter_mysql_query', $query, $this->getWpId() );
                $res_dataRows = $wpdb->get_results( $query, ARRAY_A );
                $mysql_error = $wpdb->last_error;
            }
            
            // If this is the table initialization from WP-admin, and no data is returned, throw an exception
            if( $init_read && empty( $res_dataRows ) ){
                $msg = __( 'No data fetched! ', 'wpdatatables' );
                $msg .= '<br/>' . __( 'Rendered query: ', 'wpdatatables' ) . '<strong>' . $query.'</strong><br/>';
                if( !empty( $mysql_error ) ){
                    $msg .= __(' MySQL said: ', 'wpdatatables').$mysql_error;
                }
                throw new Exception( $msg );
            }
            
            // Sending the array to arrayBasedConstruct
            return $this->arrayBasedConstruct( $res_dataRows, $wdtParameters );
            
        }
    }
    
    public function jsonBasedConstruct( $json, $wdtParameters = array() ) {
         // checking if the table is existing in cache
         // and setting the flag if it does
         if( self::$mc ) {
             $this->_cacheHash = 'bbj_'.md5( $json );
             if( @self::$mc->get( $this->_cacheHash ) ){
                 $this->_fromCache = $this->_cacheHash;
                 return true;
             }
         }
        $json = WDTTools::curlGetData( $json );
        $json = apply_filters( 'wpdatatables_filter_json', $json, $this->getWpId() );
	return $this->arrayBasedConstruct(json_decode($json, true), $wdtParameters);
    }
    
    public function XMLBasedConstruct( $xml, $wdtParameters = array() ) {
        if(!$xml) {
            throw new WDTException('File you provided cannot be found.');
        }
        if(strpos($xml, '.xml')===false){
            throw new WDTException('Non-XML file provided!');
        }
        $XMLObject = simplexml_load_file($xml);
        $XMLObject = apply_filters( 'wpdatatables_filter_simplexml', $XMLObject, $this->getWpId() );
        $XMLArray = WDTTools::convertXMLtoArr($XMLObject);
        foreach($XMLArray as &$xml_el){
            if( is_array($xml_el) && array_key_exists('attributes', $xml_el)) {
                $xml_el = $xml_el['attributes'];
            }
        }
        return $this->arrayBasedConstruct( $XMLArray, $wdtParameters );
    }
    
    public function excelBasedConstruct( $xls_url, $wdtParameters = array() ) {
    	ini_set("memory_limit", "2048M");
        if(!$xls_url) {
            throw new WDTException('Excel file not found!');
        }
        if(!file_exists($xls_url)){
            throw new WDTException('Provided file '.stripcslashes($xls_url).' does not exist!');
        }
        require_once(WDT_ROOT_PATH.'/lib/phpExcel/PHPExcel.php');
        $objPHPExcel = new PHPExcel();
        if(strpos(strtolower($xls_url), '.xlsx')){
            $objReader = new PHPExcel_Reader_Excel2007();
            $objReader->setReadDataOnly(true);
        }elseif(strpos(strtolower($xls_url), '.xls')){
            $objReader = new PHPExcel_Reader_Excel5();
            $objReader->setReadDataOnly(true);
        }elseif(strpos(strtolower($xls_url), '.ods')){
            $objReader = new PHPExcel_Reader_OOCalc();
            $objReader->setReadDataOnly(true);
        }elseif(strpos(strtolower($xls_url), '.csv')){
            $objReader = new PHPExcel_Reader_CSV();
        }else{
            throw new WDTException('File format not supported!');
        }
        $objPHPExcel = $objReader->load($xls_url);
        $objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		
		$headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
		$headingsArray = $headingsArray[1];
		
		$r = -1;
		$namedDataArray = array();
		for ($row = 2; $row <= $highestRow; ++$row) {
		    $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
		    if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
		        ++$r;
		        foreach($headingsArray as $dataColumnIndex => $dataColumnHeading) {
		            $namedDataArray[$r][$dataColumnHeading] = $dataRow[$row][$dataColumnIndex];
		            if(WDT_DETECT_DATES_IN_EXCEL){
			            $cellID = $dataColumnIndex.$row;
			            if(PHPExcel_Shared_Date::isDateTime($objPHPExcel->getActiveSheet()->getCell($cellID))){
			            	$namedDataArray[$r][$dataColumnHeading] = PHPExcel_Shared_Date::ExcelToPHP($dataRow[$row][$dataColumnIndex]);
			            }
		            }
		        }
		    }
		}
		
		$namedDataArray = apply_filters( 'wpdatatables_filter_excel_array', $namedDataArray, $this->getWpId(), $xls_url );
        
        return $this->arrayBasedConstruct($namedDataArray, $wdtParameters);
    }
    
    private function _renderWithJSAndStyles() {
        $tpl = new PDTTpl();
        $minified_js = get_option('wdtMinifiedJs');
        if(true || $this->_firstOnPage && $this->scriptsEnabled) {
	        if(WDT_INCLUDE_DATATABLES_CORE){
	             wp_register_script('datatables',WDT_JS_PATH.'jquery-datatables/jquery.dataTables.min.js',array('jquery'));
	             wp_enqueue_script('datatables');
	        }
	        if($this->TTEnabled()){
	             wp_register_script('tabletools',WDT_JS_PATH.'jquery-datatables/TableTools.min.js',array('jquery','datatables'));
	             wp_enqueue_script('tabletools');
	        }
                if( $minified_js ){
                    wp_register_script('wpdatatables-funcs',WDT_JS_PATH.'php-datatables/wpdatatables.funcs.min.js',array('jquery','datatables'));
                    wp_register_script('wpdatatables-rowgrouping',WDT_JS_PATH.'jquery-datatables/jquery.dataTables.rowGrouping.min.js',array('jquery','datatables'));
                }else{
                    wp_register_script('wpdatatables-funcs',WDT_JS_PATH.'php-datatables/wpdatatables.funcs.js',array('jquery','datatables'));
                    wp_register_script('wpdatatables-rowgrouping',WDT_JS_PATH.'jquery-datatables/jquery.dataTables.rowGrouping.js',array('jquery','datatables'));
                }
           	wp_enqueue_script('wpdatatables-funcs');
           	wp_enqueue_script('wpdatatables-rowgrouping');
                if($this->filterEnabled()){
                    if( $minified_js ){
                        wp_register_script('wpdatatables-advancedfilter',WDT_JS_PATH.'jquery-datatables/jquery.dataTables.columnFilter.min.js');
                    }else{
                        wp_register_script('wpdatatables-advancedfilter',WDT_JS_PATH.'jquery-datatables/jquery.dataTables.columnFilter.js');
                    }
                    wp_enqueue_script('wpdatatables-advancedfilter');
                }
                if($this->isEditable()){
                    wp_register_script('jquery-maskmoney',WDT_JS_PATH.'maskmoney/jquery.maskMoney.js',array('jquery'));
                    wp_enqueue_script('jquery-maskmoney');
                    // Media upload
                    wp_enqueue_script('media-upload');
                    wp_enqueue_media();
                }
                if($this->isResponsive()){
                    wp_register_script('lodash',WDT_JS_PATH.'responsive/lodash.min.js');
                    if( $minified_js ){
                        wp_register_script('wpdatatables-responsive',WDT_JS_PATH.'responsive/datatables.responsive.min.js');
                    }else{
                        wp_register_script('wpdatatables-responsive',WDT_JS_PATH.'responsive/datatables.responsive.js');
                    }
                    wp_enqueue_script('lodash');
                    wp_enqueue_script('wpdatatables-responsive');
                }
	        wp_enqueue_script('jquery-effects-core');
	        wp_enqueue_script('jquery-effects-fade');
	        if( $minified_js ){
                    wp_register_script('wpdatatables',WDT_JS_PATH.'wpdatatables/wpdatatables.min.js',array('jquery','datatables'));
                }else{
                    wp_register_script('wpdatatables',WDT_JS_PATH.'wpdatatables/wpdatatables.js',array('jquery','datatables'));
                }
	        wp_enqueue_script('wpdatatables');
                // Localization
                wp_localize_script( 'wpdatatables', 'wpdatatables_frontend_strings', WDTTools::getTranslationStrings() );
                wp_localize_script( 'wpdatatables-advancedfilter', 'wpdatatables_frontend_strings', WDTTools::getTranslationStrings() );
        }
        $this->addCSSClass( 'data-t' );
        $tpl->setTemplate( 'wpdatatables_table_main.inc.php' );
        $tpl->addData( 'wpDataTable', $this );
        return $tpl->returnData();
    }
    
    public function generateTable() {
    	
        $tpl = new PDTTpl();
        if($this->_firstOnPage && $this->scriptsEnabled) {
            $skin = get_option('wdtBaseSkin');
            if(empty($skin)){ $skin = 'skin1'; }
            $renderSkin = $skin == 'skin1' ? WDT_ASSETS_PATH.'css/wpDataTablesSkin.css' : WDT_ASSETS_PATH.'css/wpDataTablesSkin_1.css';
            $renderSkin = apply_filters( 'wpdatatables_link_to_skin_css', $renderSkin, $this->getWpId() );
            
            $cssArray = array(
                'wpdatatables-min' => WDT_CSS_PATH.'wpdatatables.min.css',
                'wpdatatables-tabletools' => WDT_CSS_PATH.'TableTools.css',
                'wpdatatables-responsive' => WDT_ASSETS_PATH.'css/datatables.responsive.css',
                'wpdatatables-skin' => $renderSkin
            );
            foreach($cssArray as $cssKey => $cssFile){
                if (defined('DOING_AJAX') && DOING_AJAX){
                    $tpl->addCss($cssFile);
                }else{
                    wp_enqueue_style( $cssKey, $cssFile );
                }
            }
        }
        $table_content = $this->_renderWithJSAndStyles();
        $tpl->addData( 'wdt_output_table', $table_content );
        $tpl->setTemplate( 'wrap_template.inc.php' );
        
        $return_data = $tpl->returnData();
        return $return_data;
    }

    /**
     * Renders the chart block, which will be supposed to render in the
     * div with provided ID
     * @param string Container div ID 
     */
    public function renderChart( $divId ) {
        if(!$divId){
            throw new WDTException('No div ID provided!');
        }
        
        do_action( 'wpdatatable_before_render_chart', $this->getWpId() );
        
        $tpl = new PDTTpl();
        $tpl->setTemplate( 'chart_js_template.inc.php' );
        $series_headers = array();
        $series_values = array();

        foreach($this->_chartSeriesArr as $dataColumnIndex){
            $series_headers[] = $this->getColumn($dataColumnIndex)->getTitle();
        }
        
        
        $chartProperties = array();
        
        $chartProperties['values'] = array();
        $chartProperties['values'][] = $series_headers;
        foreach($this->getDataRows() as $row) {
            $series_values_entry = array();
            foreach($this->_chartSeriesArr as $dataColumnIndex){
                $val = $row[$dataColumnIndex];
                if(($dataType = $this->getColumn($dataColumnIndex)->getDataType()) != 'string') {
                        if($dataType == 'date') {
                            $val = str_replace( '/', '-', $val );
                            $val = date( get_option('wdtDateFormat'), strtotime( $val ) );
                        }elseif($dataType == 'int') {
                            $val = (int)$val;
                        }elseif($dataType == 'float') {
                            $val = (float)$val;
                        }
                    $series_values_entry[] = $val;
                } else {
                    $series_values_entry[] = $val;
                }
            }
            $chartProperties['values'][] = $series_values_entry;
        }
        
        $chartProperties['type'] = $this->getChartType();
        $chartProperties['container'] = $divId;
        $chartProperties['options'] = array();
        $chartProperties['options']['title'] = $this->getChartTitle();
        if(!empty($this->_horAxisCol)){
            $chartProperties['options']['hAxis'] = array('title' => $this->getColumn($this->_horAxisCol)->getTitle());
        }
        if(!empty($this->_verAxisCol)){
            $chartProperties['options']['vAxis'] = array('title' => $this->getColumn($this->_verAxisCol)->getTitle());
        }
        $tpl->addData('tableId',$this->getId());
        $tpl->addData('chartProperties',json_encode( $chartProperties, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG ));       
        $return_data = $tpl->returnData();
   
        $return_data = apply_filters( 'wpdatatables_filter_chart', $return_data, $series_headers, $series_values, $this->getWpId() );
        
        return $return_data;
    }
    
    /**
     * Prints the rendered chart
     */
    public function printChart( $divId ) {
        if(!$divId){
            throw new WDTException('No div ID provided!');
        }        
        echo $this->renderChart( $divId );
    }    
    
    /**
     * Returns JSON object for table description
     */
     public function getJsonDescription(){
        global $wdt_var1, $wdt_var2, $wdt_var3;
         
     	$obj = new stdClass();
     	$obj->tableId = $this->getId();
     	$obj->selector = '#'.$this->getId();
     	$obj->responsive = $this->isResponsive();
     	$obj->editable = $this->isEditable();
     	$obj->hideBeforeLoad = $this->doHideBeforeLoad();
     	$obj->number_format = (int) (get_option('wdtNumberFormat') ? get_option('wdtNumberFormat') : 1);
     	$obj->decimal_places = (int) (get_option('wdtDecimalPlaces') ? get_option('wdtDecimalPlaces') : 2);
     	if($this->isEditable()){
     		$obj->fileUploadBaseUrl = site_url().'/wp-admin/admin-ajax.php?action=wdt_upload_file&table_id='.$this->getWpId();
     		$obj->adminAjaxBaseUrl =  site_url().'/wp-admin/admin-ajax.php';
     		$obj->idColumnIndex = $this->getColumnHeaderOffset($this->getIdColumnKey());
     		$obj->idColumnKey = $this->getIdColumnKey();
     	}
   		$obj->spinnerSrc = WDT_ASSETS_PATH.'/img/spinner.gif';
     	$obj->groupingEnabled = $this->groupingEnabled();
     	if($this->groupingEnabled()){
	     	$obj->groupingColumnIndex = $this->groupingColumn();
     	}
     	$obj->tableWpId = $this->getWpId();
     	$obj->dataTableParams = new StdClass();
     	$obj->dataTableParams->sDom = 'T<"clear">lftip';
     	$obj->dataTableParams->bFilter = $this->filterEnabled();
     	if($this->paginationEnabled()){
     		$obj->dataTableParams->bPaginate = true;
     		$obj->dataTableParams->aLengthMenu = json_decode('[[10,25,50,100,-1],[10,25,50,100,"All"]]');
     		$obj->dataTableParams->iDisplayLength = (int)$this->getDisplayLength();
     	}else{
     		$obj->dataTableParams->bPaginate = false;
     		if($this->groupingEnabled()){
     			$obj->dataTableParams->aaSortingFixed = json_decode('[['.$this->groupingColumn().', "asc"]]');
     		}
     	}
     	$obj->dataTableParams->aoColumnDefs = json_decode('['.$this->getColumnDefinitions().']');
     	$obj->dataTableParams->bAutoWidth = false;
     	if($this->sortEnabled() && !is_null($this->getDefaultSortColumn())){
	     	$obj->dataTableParams->aaSorting = json_decode('[['.$this->getDefaultSortColumn().', "'.strtolower($this->getDefaultSortDirection()).'" ]]');
     	}else{
     		if($this->sortEnabled()){
     			$obj->dataTableParams->aaSorting = json_decode('[[0,"asc"]]');
     		}else{
     			$obj->dataTableParams->bSort = false;
     		}
     	}
     	if($this->getInterfaceLanguage()){
            $obj->dataTableParams->oLanguage = json_decode(file_get_contents($this->getInterfaceLanguage()));
     	}
     	if($this->TTEnabled()){
     		$obj->dataTableParams->oTableTools = array(
     			'sSwfPath' => WDT_JS_PATH.'jquery-datatables/media/swf/copy_cvs_xls_pdf.swf',
     			'aButtons' => array(
     				array('sExtends' => 'xls', 'sFileName' => '*.xls', 'mColumns' => 'visible'),
     				array('sExtends' => 'print')
     				)
    			);
                if(!$this->isEditable()){
                        $obj->dataTableParams->oTableTools['aButtons'][] = array('sExtends' => 'csv', 'mColumns' => 'visible');
                        $obj->dataTableParams->oTableTools['aButtons'][] = array('sExtends' => 'pdf', 'mColumns' => 'visible');
                        $obj->dataTableParams->oTableTools['aButtons'][] = 'copy';
                }
     	}
  		$obj->dataTableParams->bProcessing = false;
     	if($this->serverSide()){
     		$obj->serverSide = true;
     		$obj->dataTableParams->bServerSide = true;
	     	$obj->dataTableParams->sAjaxSource = site_url().'/wp-admin/admin-ajax.php?action=get_wdtable&table_id='.$this->getWpId();
                if( !empty( $wdt_var1 ) ){
                    $obj->dataTableParams->sAjaxSource .= '&wdt_var1='.urlencode( $wdt_var1 );
                }
                if( !empty( $wdt_var2 ) ){
                    $obj->dataTableParams->sAjaxSource .= '&wdt_var2='.urlencode( $wdt_var2 );
                }
                if( !empty( $wdt_var3 ) ){
                    $obj->dataTableParams->sAjaxSource .= '&wdt_var3='.urlencode( $wdt_var3 );
                }
                $obj->fnServerData = true;
     	}else{
     		$obj->serverSide = false;
     	}     		
		$obj->dataTableParams->sPaginationType = 'full_numbers';	
   		$obj->columnsFixed = 0;
     	if(!$this->getNoData() && $this->advancedFilterEnabled()){
     		$obj->advancedFilterEnabled = true;
     		$obj->advancedFilterOptions = array();
	     	if(get_option('wdtRenderFilter') == 'header'){
	     		$obj->advancedFilterOptions['sPlaceHolder'] = "head:before";
	     	}
	     	if($this->getFilteringForm()){
	     		$obj->externalFilter = true;
	     	}else{
	     		$obj->externalFilter = false;
	     	}
	     	$obj->advancedFilterOptions['aoColumns'] = json_decode('['.$this->getColumnFilterDefs().']');
	     	$obj->advancedFilterOptions['bUseColVis'] = true;
     	}else{
     		$obj->advancedFilterEnabled = false;
     	}
        $init_format = get_option('wdtDateFormat');
        $datepick_format = str_replace('d','dd',$init_format);
        $datepick_format = str_replace('m','mm',$datepick_format);
        $datepick_format = str_replace('Y','yy',$datepick_format);
     	$obj->datepickFormat = $datepick_format;
     	
     	if(get_option('wdtTabletWidth')){
     		$obj->tabletWidth = get_option('wdtTabletWidth');
     	}
     	if(get_option('wdtMobileWidth')){
     		$obj->mobileWidth = get_option('wdtMobileWidth');
     	}
     	
        $obj->dataTableParams->oSearch = array( 'bSmart' => false, 'bRegex' => false );
        
     	$obj = apply_filters( 'wpdatatables_filter_table_description', $obj, $this->getWpId() );
		
     	return json_encode( $obj, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG );
     }
     
}
    
?>