<div class="wpDataTables metabox-holder toplevel_page_wpdatatables-administration">
    <div id="wdtPreloadLayer" class="overlayed">
    </div>

    <div class="wrap">
	    <div id="poststuff">
		    <div id="post-body" class="metabox-holder">
		    	<div id="postbox-container-1" class="postbox-container">
					<img src="<?php echo dirname(plugin_dir_url(__FILE__)); ?>/assets/img/wpdatatables-logo.png" class="wpdatatables_logo" />
					<p><i><?php _e('Please refer to','wpdatatables');?> <a href="http://wpdatatables.com/documentation/creating-wpdatatables/"><?php _e('wpDataTables documentation on this page','wpdatatables');?></a> <?php _e('if you have some questions or problems.','wpdatatables'); ?></i></p>
					<h2>
					    <?php echo $wpShowTitle ?>
					    <?php if (!empty($table_id)) { ?>
				    	    <a href="admin.php?page=wpdatatables-administration&action=delete&table_id=<?php echo $table_id ?>" class="add-new-h2 submitdelete"><?php _e('Delete','wpdatatables');?></a>
					    <?php } ?>
					</h2>
					<div id="message" class="updated" <?php if (empty($table_id)) { ?>style="display: none;"<?php } ?> >
					    <p id="wdtScId"><?php _e('To insert the table on your page use the shortcode','wpdatatables');?>: <strong>[wpdatatable id=<?php if (!empty($table_id)) {echo $table_id; } ?>]</strong></p>
					</div>
                                        
                    <input type='hidden' id='wdt_table_manual' value='<?php if( isset($table_data['table_type']) && ($table_data['table_type'] == 'manual') ) { echo '1'; } else { echo '0'; } ?>' />
                    <?php do_action('wpdatatables_admin_before_edit'); ?>
					<form method="post" action="<?php echo WDT_ROOT_URL ?>" id="wpDataTablesSettings">
						<div id="normal-sortables" class="meta-box-sortables ui-sortable">
							<div class="postbox">
							
								<div class="handlediv" title="<?php _e('Click to toggle','wpdatatables'); ?>"><br/></div>
							    <h3 class="hndle" style="height: 27px">
							    	<span><div class="dashicons dashicons-feedback"></div> <?php _e('Data source and main settings','wpdatatables');?></span>
								    <div class="pull-right" style="margin-right: 5px">
									    <input type="submit" name="submitStep1" class="submitStep1 button-primary" value="<?php _e('Save','wpdatatables');?>">
									    <button class="button-primary previewButton" style="display: none"><?php _e('Preview','wpdatatables');?></button>
									    <button class="button-primary closeButton"><?php _e('Close','wpdatatables');?></button>
								    </div>
							    </h3>
							
							    <div class="inside">
								    <table class="form-table wpDataTables">
									<tbody>
									    <tr>
										<td colspan="2">
										    <h3>
										    	<div class="dashicons dashicons-admin-generic"></div> <?php _e('General setup','wpdatatables');?>
										    </h3>
										</td>
									    </tr>

									    <tr>
										<td colspan="2">
										</td>
									    </tr>
									    
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpTableTitle"><?php _e('Table title','wpdatatables');?></label>
										</th>
										<td>
										    <input type="text" id="wpTableTitle" name="wpTableTitle" value="<?php if (!empty($table_data['title'])) echo $table_data['title'] ?>" /><br/>
										    <span class="description"><?php _e('If you want to display a header above your table, enter it here','wpdatatables');?>.</span>
										</td>
									    </tr>
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpShowTableTitle"><?php _e('Show table title','wpdatatables');?></label>
										</th>
										<td>
                                                                                    <input type="checkbox" id="wpShowTableTitle" name="wpShowTableTitle" <?php if ((isset($table_data['show_title']) && ($table_data['show_title'] == 1) ) || !isset( $table_data['show_title'] ) ){ ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Uncheck if you do not want to show the table title on the page','wpdatatables');?>.</span>
										</td>
									    </tr>                                                                            
                                                                            <?php if( empty($table_data['table_type']) || ( isset($table_data['table_type']) && $table_data['table_type'] != 'manual' ) ){ ?>
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpTableType"><?php _e('Table type','wpdatatables');?></label>
										</th>
										<td>
										    <select name="wpTableType" id="wpTableType" class="wpDataTables">
											<option value=""><?php _e('Select a table type...','wpdatatables');?></option>
											<option value="mysql" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'mysql') { ?>selected="selected"<?php } ?>><?php _e('MySQL query','wpdatatables');?></option>
											<option value="csv" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'csv') { ?>selected="selected"<?php } ?>><?php _e('CSV file','wpdatatables');?></option>
											<option value="xls" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'xls') { ?>selected="selected"<?php } ?>><?php _e('Excel file','wpdatatables');?></option>
											<option value="google_spreadsheet" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'google_spreadsheet') { ?>selected="selected"<?php } ?>><?php _e('Google spreadsheet','wpdatatables');?></option>
											<option value="xml" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'xml') { ?>selected="selected"<?php } ?>><?php _e('XML file','wpdatatables');?></option>
											<option value="json" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'json') { ?>selected="selected"<?php } ?>><?php _e('JSON file','wpdatatables');?></option>
											<option value="serialized" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'serialized') { ?>selected="selected"<?php } ?>><?php _e('Serialized PHP array','wpdatatables');?></option>
										    </select><br/>
										    <span class="description"><?php _e('Choose a type of input source for your table','wpdatatables');?>.</span>
										</td>
									    </tr>
                                                                            <?php } else { ?>
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpTableType"><?php _e('Edit data','wpdatatables');?></label>
										</th>
										<td>
        									    <a href="admin.php?page=wpdatatables-editor&table_id=<?php echo $table_id ?>" class="button-primary"><?php _e('Go to editor', 'wpdatatables'); ?></a><br/><br/>
										    <span class="description"><?php _e('Open the table in back-end editor to modify table data','wpdatatables');?>.</span>
										</td>
									    </tr>
                                                                            <?php } ?>
									    <tr valign="top" class="mysqlquery_row step1_row">
										<th scope="row">
										    <label for="wpMySQLQuery" class="tooltip" data-title="<?php _e('Enter MySQL SELECT query that will return the data for your wpDataTable. Make sure that this query works and returns data. If you are not sure what is a MySQL query please consider using Excel data source, or spend some time reading MySQL manuals','wpdatatables');?>."><?php _e('MySQL query','wpdatatables');?></label>
										</th>
										<td>
										    <pre id="wpMySQLQuery" style="width: 600px; height: 250px"><?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'mysql') {
                                                                                        echo htmlentities($table_data['content']);
                                                                                    } ?></pre><br/>
                                                                                    <div><span class="description"><?php _e('Enter the text of your MySQL query here. You can use a number of placeholders to make the dataset in the table flexible and be able to return different sets of data by calling it with different shortcodes','wpdatatables');?>.</span></div>
                                                                                    <button class="button" id="wdtPlaceholdersTableToggle" style="margin-top: 10px"><span class="dashicons dashicons-arrow-down-alt2" style="line-height: 27px;"></span> <?php _e('MySQL query placeholders (toggle show/hide)','wpdatatables'); ?></button>
                                                                                    <table id="wdtPlaceholdersTable" style="display: none">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th><?php _e('Placeholder','wpdatatables'); ?></th>
                                                                                                <th><?php _e('Description, example','wpdatatables'); ?></th>
                                                                                                <th><?php _e('Define default for table generation','wpdatatables'); ?></th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td><strong>%CURRENT_USER_ID%</strong></td>
                                                                                                <td>
                                                                                                    <?php _e('Returns the numeric value of the currently logged in user ID (wp_users table). Returns 0 for non-logged in users. If your current user does not have rows in the table you can redefine it here (it will not be stored, used only to read the table structure).','wpdatatables'); ?><br/>
                                                                                                    <strong><?php _e('Example: SELECT * FROM mytable WHERE user_id = %CURRENT_USER_ID%','wpdatatables'); ?></strong>
                                                                                                </td>
                                                                                                <td><input type="text" id="wdtCurrentUserIdPlaceholderDefault" value="<?php echo get_current_user_id() ?>" /></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>%VAR1%</strong></td>
                                                                                                <td>
                                                                                                    <?php _e('Variable for using in the shortcode. Can be used in filter values. It is necessary for wpDataTables to retrieve actual data from the DB at the moment of wpDataTable generation to read the columns structure, so make sure the query returns something. You can define the default variables values here, they will be used for table creation, and as defaults if not defined in shortcode.','wpdatatables'); ?><br/>
                                                                                                    <strong><?php _e('Example: SELECT * FROM mytable WHERE mycolumn >= %VAR1% AND mycolumn <= %VAR2%','wpdatatables'); ?></strong>
                                                                                                </td>
                                                                                                <td><input type="text" id="wdtVar1PlaceholderDefault" value="<?php if (!empty($table_data['var1'])){ echo $table_data['var1']; } ?>" /></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>%VAR2%</strong></td>
                                                                                                <td>
                                                                                                    <?php _e('Variable for using in the shortcode.','wpdatatables'); ?><br/>
                                                                                                </td>
                                                                                                <td><input type="text" id="wdtVar2PlaceholderDefault" value="<?php if (!empty($table_data['var1'])){ echo $table_data['var2']; } ?>" /></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>%VAR3%</strong></td>
                                                                                                <td>
                                                                                                    <?php _e('Variable for using in the shortcode.','wpdatatables'); ?><br/>
                                                                                                </td>
                                                                                                <td><input type="text" id="wdtVar3PlaceholderDefault" value="<?php if (!empty($table_data['var1'])){ echo $table_data['var3']; } ?>" /></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><strong>%WPDB%</strong></td>
                                                                                                <td>
                                                                                                    <?php _e('Prefix of the current WordPress DB installation. Defaults to "wp_", but may be different if defined so in WordPress config.','wpdatatables'); ?><br/>
                                                                                                </td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
										</td>
									    </tr>
									    <tr valign="top" class="inputfile_row step1_row">
										<th scope="row">
										    <label for="wpInputFile"><?php _e('Input file or URL','wpdatatables');?></label>
										</th>
										<td>
										    <input type="text" id="wpInputFile" name="wpInputFile" value="<?php if (!empty($table_data['table_type']) && $table_data['table_type'] != 'mysql') {
									echo str_replace(ABSPATH, site_url(), $table_data['content']);
								    } ?>" />
										    <input id="wpUploadFileBtn" type="button" value="Upload file" class="button" /><br/>
                                                                                    <span class="description"><?php _e('Upload your file or provide the full URL here','wpdatatables');?>.<br/><b><?php _e('For CSV or Excel input sources only uploaded files are supported','wpdatatables');?></b><br/><b><?php _e('For Google Spreadsheets: please do not forget to publish the spreadsheet before pasting the URL.','wpdatatables');?></b>.</span>
										</td>
									    </tr>
									    <tr valign="top" class="table_editable_row step1_row">
										<th scope="row">
										    <label for="wpTableEditable"><?php _e('Front-end editing','wpdatatables');?></label>
										</th>
										<td>
                                                                                    <input type="checkbox" <?php if( empty( $table_id ) ) { ?>disabled="disabled"<?php } ?> id="wpTableEditable" name="wpTableEditable" <?php if (!empty($table_data['editable']) && ($table_data['editable'] == '1')) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Make table editable from the front-end','wpdatatables');?>.<br/><b><?php _e('Works only for MySQL-based tables with server-side processing, and can only update one table on MySQL side','wpdatatables');?></b>.</span><br/>
                                                                                    <?php if( empty( $table_id ) ) { ?><span class="description"><?php _e('Please save the table first so wpDataTables would read the columns data so that feature would become available.','wpdatatables');?></span><?php } ?>
										</td>
									    </tr>
									    <tr valign="top" class="table_mysql_name_row step1_row">
										<th scope="row">
										    <label for="wpTableMysqlName"><?php _e('MySQL table name for editing','wpdatatables');?></label>
										</th>
										<td>
										    <input type="text" id="wpTableMysqlName" name="wpTableMysqlName" value="<?php if (!empty($table_data['mysql_table_name'])) {
									echo $table_data['mysql_table_name'];
								    } ?>" />
										    <span class="description"><?php _e('Name of the MySQL table which will be used for updates from front-end','wpdatatables');?>.</span>
										</td>        
									    </tr>
                                                                            <tr valign="top" class="step1_row id_column_row" <?php if( empty( $table_data['editable'] ) ) { ?>style="display: none"<?php } ?>>
										<th scope="row">
										    <label for="wpUserIdColumn"><?php _e('ID column for editing','wpdatatables');?></label>
										</th>
                                                                                <td>
                                                                                    <?php if( empty( $table_id ) ) { ?>
                                                                                    <small><?php _e( 'Please save the table first so wpDataTables would initialize the columns','wpdatatables' ); ?></small>
                                                                                    <?php } else { ?>
										    <select name="wdtIdColumn" id="wdtIdColumn">
											<option value=""><?php _e('Please choose an ID column for editing...','wpdatatables');?></option>
                                                                                        <?php foreach( $column_data as $column ){ ?>
                                                                                        <option value="<?php echo $column->id ?>" <?php if( $column->id_column ) { ?>selected="selected"<?php } ?>><?php echo $column->orig_header ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                    <?php } ?>
                                                                                    <br/>
                                                                                    <span class="description"><?php _e('Please choose a column, values from which will be used as row unique identifier. MUST be auto-increment integer on MySQL side so insert/edit/delete would work correctly!','wpdatatables');?>.</span><br/>
                                                                                    <span class="description"><small><?php _e('wpDataTables will guess the correct column if it is called "id" or "ID" on MySQL side','wpdatatables');?></small>.</span>
                                                                                </td>
                                                                            </tr>
									    <tr valign="top" class="editing_own_rows_row step1_row">
										<th scope="row">
										    <label for="wpTableEditingOwnRowsOnly"><?php _e('Users see and edit only their data','wpdatatables');?></label>
										</th>
										<td>
										    <input type="checkbox" id="wpTableEditingOwnRowsOnly" name="wpTableEditingOwnRowsOnly" <?php if (!empty($table_data['edit_only_own_rows']) && ($table_data['edit_only_own_rows'] == '1')) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Limit editing to user\'s own data only','wpdatatables');?>.<br/><b><?php _e('Set this to checked if you would like front-end users to see and edit only their own data, i.e. rows with their WordPress user ID.','wpdatatables');?></b>.</span>
										</td>
									    </tr>
                                                                            <tr valign="top" class="step1_row user_id_row" <?php if( empty( $table_data['edit_only_own_rows'] ) ) { ?>style="display: none"<?php } ?>>
										<th scope="row">
										    <label for="wpUserIdColumn"><?php _e('User ID column','wpdatatables');?></label>
										</th>
                                                                                <td>
                                                                                    <?php if( empty( $table_id ) ) { ?>
                                                                                    <small><?php _e( 'Please save the table first so wpDataTables would initialize the columns','wpdatatables' ); ?></small>
                                                                                    <?php } else { ?>
										    <select name="wpUserIdColumn" id="wpUserIdColumn" class="wpDataTables">
											<option value=""><?php _e('Please choose a user ID column...','wpdatatables');?></option>
                                                                                        <?php foreach( $column_data as $column ){ ?>
                                                                                        <option value="<?php echo $column->id ?>" <?php if( $table_data['userid_column_id'] == $column->id ) { ?>selected="selected"<?php } ?>><?php echo $column->orig_header ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                    <?php } ?>
                                                                                </td>
                                                                            </tr>
									    <tr valign="top" class="editor_roles_row step1_row">
										<th scope="row">
										    <label for="wpTableEditorRoles"><?php _e('Editor roles','wpdatatables');?></label>
										</th>
										<td>
										    <div id="wpTableEditorRoles"><?php echo !empty($table_data['editor_roles']) ? $table_data['editor_roles'] : ''; ?></div>
										    <button class="button" id="selectEditorRoles"><?php _e('Choose roles','wpdatatables');?></button>
										    <span class="description"><?php _e('Roles which are allowed to edit the table (leave blank to alllow editing for everyone)','wpdatatables');?>.</span>
										</td>        
									    </tr>
									    <tr>
										<td colspan="2">
										    <h3><div class="dashicons dashicons-editor-kitchensink"></div> <?php _e('Additional settings','wpdatatables');?></h3>
										</td>
									    </tr>
									    <tr valign="top" class="step1_row serverside_row">
										<th scope="row">
										    <label for="wpServerSide"><?php _e('Server-side processing','wpdatatables');?></label>
										</th>
										<td>
										    <input type="checkbox" id="wpServerSide" <?php if (isset($table_data['server_side']) && $table_data['server_side']) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Server-side processing for MySQL-based tables. Required for front-end editing','wpdatatables');?>.</span>
										</td>
									    </tr>
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wdtResponsive"><?php _e('Responsive','wpdatatables');?></label>
										</th>
										<td>
										    <input type="checkbox" id="wdtResponsive" <?php if (isset($table_data['responsive']) && $table_data['responsive']) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Check this checkbox if you would like this table to be responsive - display differently on desktops, tablets and mobiles','wpdatatables');?>.</span>
										</td>
									    </tr> 
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wdtHideBeforeLoaded"><?php _e('Hide table until page is completely loaded','wpdatatables');?></label>
										</th>
										<td>
										    <input type="checkbox" id="wdtHideBeforeLoaded" <?php if (!isset($table_data['hide_before_load']) || $table_data['hide_before_load']) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Check this checkbox if you would prevent table from showing until the page loads completely. May be useful for slowly loading pages','wpdatatables');?>.</span>
										</td>
									    </tr>        
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpAdvancedFilter"><?php _e('Advanced filtering','wpdatatables');?></label>
										</th>
										<td>
										    <input type="checkbox" id="wpAdvancedFilter" <?php if (!isset($table_data['filtering']) || $table_data['filtering']) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Check this checkbox if you would like to have a filter below each column','wpdatatables');?>.</span>
										</td>
									    </tr>        
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpAdvancedFilterForm"><?php _e('Filter in form','wpdatatables');?></label>
										</th>
										<td>
										    <input type="checkbox" id="wpAdvancedFilterForm" <?php if (isset($table_data['filtering_form']) && $table_data['filtering_form']) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Check this checkbox if you would like to have the advanced filter in a form','wpdatatables');?></span>
										</td>
									    </tr>        
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpTableTools"><?php _e('Table tools','wpdatatables');?></label>
										</th>
										<td>
										    <input type="checkbox" id="wpTableTools" <?php if (!isset($table_data['tools']) || $table_data['tools']) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Check this checkbox if you would like to have the table tools (copy, save to excel, save to CSV, etc) enabled for this table','wpdatatables');?>.</span>
										</td>
									    </tr>
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpSortByColumn"><?php _e('Enable sorting','wpdatatables');?></label>
										</th>
										<td>
										    <input type="checkbox" id="wpSortByColumn" <?php if (!isset($table_data['sorting']) || $table_data['sorting']) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Check this checkbox if you would like to have sorting feature in your table','wpdatatables');?>.</span>
										</td>
									    </tr>
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpFixedLayout"><?php _e('Limit table layout','wpdatatables');?></label>
										</th>
										<td>
										    <input type="checkbox" id="wpFixedLayout" <?php if (isset($table_data['fixed_layout']) && $table_data['fixed_layout']) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Check this checkbox if you would like to limit the table\'s width to 100% of parent container (div)','wpdatatables');?>.</span>
										</td>
									    </tr>
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpWordWrap"><?php _e('Word wrap','wpdatatables');?></label>
										</th>
										<td>
										    <input type="checkbox" id="wpWordWrap" <?php if (isset($table_data['word_wrap']) && $table_data['word_wrap']) { ?>checked="checked"<?php } ?> />
										    <span class="description"><?php _e('Check this checkbox if you would like words in cells to wrap and to extend row\'s height. Leave unchecked if you want to leave one-line row heights.','wpdatatables');?></span>
										</td>
									    </tr>
									    <tr valign="top" class="step1_row">
										<th scope="row">
										    <label for="wpDisplayLength"><?php _e('Display length','wpdatatables');?></label>
										</th>
										<td>
										    <select id="wpDisplayLength" class="wpDataTables">
											<option value="10" <?php if (isset($table_data['display_length']) && $table_data['display_length'] == '10') { ?>selected="selected"<?php } ?>>10 <?php _e('entries','wpdatatables');?></option>
											<option value="25" <?php if (isset($table_data['display_length']) && $table_data['display_length'] == '25') { ?>selected="selected"<?php } ?>>25 <<?php _e('entries','wpdatatables');?></option>
											<option value="50" <?php if (isset($table_data['display_length']) && $table_data['display_length'] == '50') { ?>selected="selected"<?php } ?>>50 <?php _e('entries','wpdatatables');?></option>
											<option value="100" <?php if (isset($table_data['display_length']) && $table_data['display_length'] == '100') { ?>selected="selected"<?php } ?>>100 <?php _e('entries','wpdatatables');?></option>
											<option value="0" <?php if (isset($table_data['display_length']) && $table_data['display_length'] == '0') { ?>selected="selected"<?php } ?>><?php _e('All','wpdatatables');?></option>
										    </select><br/> 
										    <span class="description"><?php _e('This options defines the default number of entries on the page for this table','wpdatatables');?>.</span>
										</td>
									    </tr>
									    <tr>
										<td colspan="2">
										    <input type="submit" name="submitStep1" class="submitStep1 button-primary" value="<?php _e('Save','wpdatatables');?>">
										    <button class="button-primary previewButton" style="display: none"><?php _e('Preview','wpdatatables');?></button>
										    <button class="button-primary closeButton"><?php _e('Close','wpdatatables');?></button>
										</td>
									    </tr>
								    </tbody>
									</table>
								</div>
							</div>
						</div>
						
						
						<div id="step2-postbox" class="meta-box-sortables ui-sortable" style="display: none">
							<div class="postbox">
							
								<div class="handlediv" title="<?php _e('Click to toggle','wpdatatables'); ?>"><br/></div>
							    <h3 class="hndle" style="height: 27px">
							    	<span><div class="dashicons dashicons-exerpt-view"></div> <?php _e('Optional column setup','wpdatatables');?></span>
								    <div class="pull-right" style="margin-right: 5px">
										    <input type="submit" name="submitStep2" class="button-primary submitStep2" value="<?php _e('Save','wpdatatables');?>">
										    <button class="button-primary ungroupButton"><?php _e('Ungroup','wpdatatables');?></button>
										    <button class="button-primary previewButton" style="display: none"><?php _e('Preview','wpdatatables');?></button>
										    <button class="button-primary closeButton"><?php _e('Close','wpdatatables');?></button>
								    </div>
							    </h3>
							
							    <div class="inside" style="overflow: scroll">
									<table>
									<tbody>
									    <tr class="step2_row">
										<td colspan="2">
										    <p><?php _e('You can change the column settings in this step, but this is not required, since default options have already been generated for you','wpdatatables');?>.</p>
										    <span class="description"><strong><?php _e('Warning','wpdatatables');?>:</strong> <?php _e('If you change the table settings, save the table before modifying the column settings, because the column set can be changed and you may lose your changes','wpdatatables');?>.</span>
										</td>
									    </tr>        
									    <tr class="step2_row">
										<td colspan="2" class="columnsBlock">
										</td>
									    </tr>        
									    <tr class="step2_row">
										<td colspan="2">
										    <input type="submit" name="submitStep2" class="button-primary submitStep2" value="<?php _e('Save','wpdatatables');?>">
										    <button class="button-primary ungroupButton"><?php _e('Ungroup','wpdatatables');?></button>
										    <button class="button-primary previewButton" style="display: none"><?php _e('Preview','wpdatatables');?></button>
										    <button class="button-primary closeButton"><?php _e('Close','wpdatatables');?></button>
										</td>
									    </tr>  
							
								    </table>
								</div>
							</div>
						</div>
					    <input type="hidden" id="wpDataTableId" value="<?php if (!empty($table_id)) {
						echo $table_id;
					    } ?>" />
					</form>

		    </div>
	    </div>
    </div>
</div>

<div id="wdtUserRoles" title="<?php _e('Editor roles','wpdatatables'); ?>">
	<p><?php _e('Choose user roles allowed to edit this table (leave blank to alllow editing for everyone):','wpdatatables'); ?></p>
	<?php if(isset($table_data)){ ?>
		<?php $wdtUserRolesArr = explode(',',$table_data['editor_roles']); ?>
		<?php foreach($wdtUserRoles as $userRole){ ?>
			<div class="wdtUserRoleBlock">
			<input class="wdtRoleCheckbox" type="checkbox" id="wdtRole_<?php echo $userRole['name']?>" value="<?php echo $userRole['name']?>" <?php if(in_array($userRole['name'],$wdtUserRolesArr)) { ?>checked="checked"<?php } ?>  />
			<label for="wdtRole_<?php echo $userRole['name']?>">
				<?php echo $userRole['name']?>
			</label>
			</div>
		<?php } ?>
	<?php } ?>
</div>

<script type="text/javascript">

    var columns_data = <?php if (!empty($column_data)) {
		echo json_encode(stripslashes_deep($column_data));
	    } else {
		echo json_encode(array());
	    } ?>;
    var preview_called = false;

</script>

<script id="columnsTableTmpl" type="text/x-jsrender">
	<table>
		<tr class="sort_columns_block">
		{{for columns_data tmpl="#columnBlockTmpl" ~filterTypes=filterTypes ~columnTypes=columnTypes ~editorTypes=editorTypes ~tableEditable=tableEditable /}}
		</tr>
	</table>
</script>

<script id="columnBlockTmpl" type="text/x-jsrender">
	<td data-column_id="{{>id}}" data-column_key="{{>display_header}}">
		<table class="column_table" rel="{{>id}}" data-table_id="{{>table_id}}">
			<tr class="columnHeaderRow">
				<td colspan="2">
					<b>{{>orig_header}}</b>
				</td>
			</tr>
			<tr>
				<td>
					<b><?php _e('Displayed header','wpdatatables');?></b>:
				</td>
				<td>
					<input type="text" class="displayHeader" value="{{if display_header != ''}}{{>display_header}}{{else}}{{>orig_header}}{{/if}}" />
				</td>
			</tr>
			<tr>
				<td>
					<b><?php _e('CSS class(es)','wpdatatables');?></b>:
				</td>
				<td>
					<input type="text" class="cssClasses" value="{{>css_class}}" />
				</td>
			</tr>
			<tr>
				<td>
					<b><?php _e('Possible values','wpdatatables');?></b>:
					<button class="button button-primary showHint">?</button><br/>
					<small class="hint" style="display: none"><?php _e('Separate with','wpdatatables');?> "|". <?php _e('Used in advanced filterdropdown and in the editor dialog','wpdatatables');?>.</small>
				</td>
				<td>
					<input type="text" class="possibleValues" value="{{>possible_values}}" />
				</td>
			</tr>
			<tr>
				<td>
					<b><?php _e('Default value(s)','wpdatatables');?></b>: 
					<button class="button button-primary showHint">?</button><br/>
					<small class="hint" style="display: none"><?php _e('Predefined filter value, default editor input value. Separate multiple values with "|". Placeholders supported.','wpdatatables');?></small>
				</td>
				<td>
					<input type="text" class="defaultValue" value="{{>default_value}}" />
				</td>
			</tr>
			<tr>
				<td>
					<b><?php _e('Filter type','wpdatatables');?></b>:
				</td>
				<td>
					<select class="filterType wpDataTables">
						{{for ~filterTypes tmpl="#selectTemplate" ~selected=filter_type /}}
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b><?php _e('Column type','wpdatatables');?></b>:
				</td>
				<td>
					<select class="columnType wpDataTables">
						{{for ~columnTypes tmpl="#selectTemplate" ~selected=column_type /}}
					</select>
				</td>
			</tr>
			{{if ~tableEditable}}
			<tr class="editable_table_column_row">
				<td>
					<b><?php _e('Editor input type:','wpdatatables');?></b>
				</td>
				<td>
					<select class="inputType wpDataTables">
						{{for ~editorTypes tmpl="#selectTemplate" ~selected=input_type /}}
					</select>
				</td>
			</tr>
			<tr class="editable_table_column_row">
				<td>
                                    <b><?php _e('Cannot be empty:','wpdatatables');?></b>
				</td>
				<td>
                                    <input type="checkbox" class="mandatoryInput" {{if input_type=="none"}}disabled="disabled"{{/if}} {{if input_mandatory == 1}}checked="checked"{{/if}} />
				</td>
			</tr>
			{{/if}}
			<tr class="responsive_table_column_row">
				<td>
					<b><?php _e('Hide on tablets','wpdatatables');?></b>
				</td>
				<td>
					<fieldset>
						<input type="checkbox" id="hideOnTablets_{{:#index}}" class="hideOnTablets" {{if hide_on_tablets=='1'}}checked="checked"{{/if}} />
						<label for="hideOnTablets_{{:#index}}"></label>
					</fieldset>
				</td>
			</tr>
			<tr class="responsive_table_column_row">
				<td>
					<b><?php _e('Hide on mobiles','wpdatatables');?></b>
				</td>
				<td>
					<fieldset>
						<input type="checkbox" id="hideOnMobiles_{{:#index}}" class="hideOnPhones" {{if hide_on_phones=='1'}}checked="checked"{{/if}} />
						<label for="hideOnMobiles_{{:#index}}">
					</fieldset>
				</td>
			</tr>
			<tr class="group_row">
				<td>
					<b><?php _e('Group column','wpdatatables');?></b>:
				</td>
				<td>
					<fieldset>
						<input type="radio" id="groupColumn_{{:#index}}" class="groupColumn" name="groupColumn" {{if group_column=='1'}}checked="checked"{{/if}} />
						<label for="groupColumn_{{:#index}}"></label>
					</fieldset>
				</td>
			</tr>
			<tr class="sort_row">
				<td>
					<b><?php _e('Default sort column','wpdatatables');?></b>:
				</td>
				<td>
					<fieldset>
						<input value="1" type="radio" id="sortColumnYes_{{:#index}}" class="sortColumn" name="sortColumn" {{if sort_column=='1'}}checked="checked"{{/if}} /> 
						<label for="sortColumnYes_{{:#index}}"><?php _e('Ascending','wpdatatables');?></label><br/>
						<input value="2" type="radio" id="sortColumnNo_{{:#index}}" class="sortColumn" name="sortColumn" {{if sort_column=='2'}}checked="checked"{{/if}} /> 
						<label for="sortColumnNo_{{:#index}}"><?php _e('Descending','wpdatatables');?></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<b><?php _e('Column position','wpdatatables');?></b>:
				</td>
				<td>
					<input type="text" class="columnPos" value="{{>pos}}" />
				</td>
			</tr>
			<tr>
				<td>
					<b><?php _e('Width','wpdatatables');?></b>:
					<button class="button button-primary showHint">?</button><br/>
					<small class="hint" style="display: none"><?php _e('Input width for column (in percents with % or pixels without "px"). Leave blank if you want to leave auto width','wpdatatables');?>.</small>
				</td>
				<td>
					<input type="text" class="columnWidth" value="{{>width}}" />
				</td>
			</tr>
                        <tr>
				<td>
					<b><?php _e('Display text before','wpdatatables');?></b>:
				</td>
				<td>
                                    <input type="text" class="textBefore" value="{{>text_before}}" />
				</td>
                        </tr>
                        <tr>
				<td>
					<b><?php _e('Display text after','wpdatatables');?></b>:
				</td>
				<td>
                                    <input type="text" class="textAfter" value="{{>text_after}}" />
				</td>
                        </tr>
                        <tr>
				<td>
					<b><?php _e('Color','wpdatatables');?></b>:
				</td>
				<td>
                                    <input type="text" class="color" value="{{>color}}" />
				</td>
                        </tr>
			<tr>
				<td>
					<b><?php _e('Visible','wpdatatables');?></b>:
				</td>
				<td>
					<fieldset>
						<input type="checkbox" id="colVisible_{{:#index}}" class="columnVisible" {{if visible=='1'}}checked="checked"{{/if}} />
						<label for="colVisible_{{:#index}}"></label>
					</fieldset>
				</td>
			</tr>
		</table>
	</td>
</script>

<script id="selectTemplate" type="text/x-jsrender">
	<option value="{{>name}}" {{if name==~selected}}selected="selected"{{/if}}>{{>value}}</option>
</script>
