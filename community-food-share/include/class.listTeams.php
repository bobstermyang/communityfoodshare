<?php

    if(!class_exists('WP_List_Table')){
        require_once( ABSPATH . 'wp-admin/includes/template.php' );
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }
    if( ! class_exists('WP_Screen') ) {
        require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    }
    class cfsTeams extends WP_List_Table {
        var $table_data = array();
        /** ************************************************************************
        * REQUIRED. Set up a constructor that references the parent constructor. We 
        * use the parent reference to set some default configs.
        ***************************************************************************/
        function __construct(){
            global $status, $page,$wpdb;
            $this->table_data =$this->fnGetTeamData();            
            parent::__construct( array(
                'singular'  => 'Team',     //singular name of the listed records
                'plural'    => 'Teams',    //plural name of the listed records
                'ajax'      => false        //does this table support ajax?
            ));
          
        }       
        function fnGetTeamData(){
            global $wpdb;
            $data=array();
            $query = 'SELECT * FROM '.$wpdb->prefix.'cfs_team';
            if(isset($_REQUEST['cid'])){
                $query .= ' WHERE company_id ='.$_REQUEST['cid'];
            }
            
            $teams = $wpdb->get_results($query);
            
            // Array of team objects.
            foreach ( $teams as $team ) {
                $donation = $this->get_team_donation($team->id);
                $data[] = array('id' => $team->id, 'team_name' => $team->team_name, 'company_name' => get_the_title($team->company_id), 'received_donation' => ($donation ? $donation : 0 ).' $', 'view_donators' => '<a href="admin.php?page=cfs_donator&tid='.$team->id.'">View Donators</a>');
            }
            return $data;
        }
        function get_team_donation($team_id){
            global $wpdb;
            return $wpdb->get_var('SELECT SUM(`amount`) FROM '.$wpdb->prefix.'cfs_donator'.' WHERE team_id ='.$team_id);
        }
        function extra_tablenav($which) {
            /*
            $x=$which=='bottom'?2:1;  
            $selected='';
            if(isset($_REQUEST['pt_payment_methods']) && $_REQUEST['pt_payment_methods']=="Paypal"){
                $selected="selected='selected'";
            }
            $payMethodDropdown='<select size="3" class="pt-selects" multiple="true" name="pt_payment_methods" style="height:66px"><option   '.(isset($_REQUEST['pt_payment_methods']) && ($_REQUEST['pt_payment_methods'] =="Paypal"  || $_REQUEST['pt_payment_methods'] )=="Authorize.Net" ? '' : 'selected').' value="0">Both</option>';
            $selected='';
            if(isset($_REQUEST['pt_payment_methods']) && $_REQUEST['pt_payment_methods']=="Paypal"){
                $selected="selected='selected'";
            }
            $payMethodDropdown.='<option value="Paypal" '.$selected.'>Paypal</option>';
            $selected='';
            if(isset($_REQUEST['pt_payment_methods']) && $_REQUEST['pt_payment_methods']=="Authorize.Net"){
                $selected="selected='selected'";
            }
            $payMethodDropdown.='<option value="Authorize.Net" '.$selected.'>Authorize.Net</option></select>';
             
            $payTypeDropdown='<select size="3" class="pt-selects" multiple="true"  name="pt_payment_type" style="height:66px"><option  '.(isset($_REQUEST['pt_payment_type']) && ($_REQUEST['pt_payment_type']=="Recurring"  || $_REQUEST['pt_payment_type']=="Payment") ? '' : 'selected').' value="0" >Both</option>';
            $selected='';
            if(isset($_REQUEST['pt_payment_type']) && $_REQUEST['pt_payment_type']=="Recurring"){
                $selected="selected='selected'";
            }  
            $payTypeDropdown.='<option value="Recurring" '.$selected.'>Recurring</option>';         
            $selected='';
            if(isset($_REQUEST['pt_payment_type']) && $_REQUEST['pt_payment_type']=="Payment"){
                $selected="selected='selected'";
            }            
            $payTypeDropdown.='<option value="Payment" '.$selected.'>One Time</option></select>'; 
                   
            if($which=='top'){
                echo '<div class="alignleft actions bulkactions ">'.$payMethodDropdown.$payTypeDropdown.'</div>';
                echo '<div class="alignleft actions bulkactions"><input type="submit" class="button action" value="Apply" /></div>';
                echo '<div class="alignleft actions bulkactions"><a href="'.admin_url('admin.php?page=pt_transactions').'" class="button action" >Clear</a></div>';
                
            }
            */
        }
        function column_default($item, $column_name){
            switch($column_name){            
                case 'cb':
                case 'team_name':
                case 'company_name':
                case 'received_donation':
                case 'view_donators':                        
                    return $item[$column_name];
                default:
                    return print_r($item,true); //Show the whole array for troubleshooting purposes
            }
        }
        
        /** ************************************************************************
        * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
        * is given special treatment when columns are processed. It ALWAYS needs to
        * have it's own method.
        * 
        * @see WP_List_Table::::single_row_columns()
        * @param array $item A singular item (one full row's worth of data)
        * @return string Text to be placed inside the column <td> (movie title only)
        **************************************************************************/
        function column_cb($item){
            return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
            );
        }


        /** ************************************************************************
        * REQUIRED! This method dictates the table's columns and titles. This should
        * return an array where the key is the column slug (and class) and the value 
        * is the column's title text. If you need a checkbox for bulk actions, refer
        * to the $columns array below.
        * 
        * The 'cb' column is treated differently than the rest. If including a checkbox
        * column in your table you must create a column_cb() method. If you don't need
        * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
        * 
        * @see WP_List_Table::::single_row_columns()
        * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
        **************************************************************************/
        function get_columns(){ 
            $arrPost=isset($_REQUEST)?$_REQUEST:array();            
            $columns = array(  
            'cb'        => '<input type="checkbox" />',
            'team_name'     => 'Team Name', 
            'company_name'  => 'Company Name', 
            'received_donation'    => 'Received Donation Amount',                          
            'view_donators' =>  '',                    
            );
          
            return $columns;
        }


        /** ************************************************************************
        * Optional. If you want one or more columns to be sortable (ASC/DESC toggle), 
        * you will need to register it here. This should return an array where the 
        * key is the column that needs to be sortable, and the value is db column to 
        * sort by. Often, the key and value will be the same, but this is not always
        * the case (as the value is a column name from the database, not the list table).
        * 
        * This method merely defines which columns should be sortable and makes them
        * clickable - it does not handle the actual sorting. You still need to detect
        * the ORDERBY and ORDER querystring variables within prepare_items() and sort
        * your data accordingly (usually by modifying your query).
        * 
        * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
        **************************************************************************/
        function get_sortable_columns() {
            $sortable_columns = array(
            'team_name'     => array('team_name',false),     //true means it's already sorted
            'company_name'    => array('company_name',false),            
            );
            $sortable_columns = array();
            return $sortable_columns;
        }


        /** ************************************************************************
        * Optional. If you need to include bulk actions in your list table, this is
        * the place to define them. Bulk actions are an associative array in the format
        * 'slug'=>'Visible Title'
        * 
        * If this method returns an empty value, no bulk action will be rendered. If
        * you specify any bulk actions, the bulk actions box will be rendered with
        * the table automatically on display().
        * 
        * Also note that list tables are not automatically wrapped in <form> elements,
        * so you will need to create those manually in order for bulk actions to function.
        * 
        * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
        **************************************************************************/
        /*
        function get_bulk_actions() {
            $actions = array(
            'export'    => 'Export',
            'exportAll' => 'Export All',           
            );
           
            return $actions;
        }


        /** ************************************************************************
        * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
        * For this example package, we will handle it in the class to keep things
        * clean and organized.
        * 
        * @see $this->prepare_items()
        **************************************************************************/
        function process_bulk_action() {            
                              
            //Detect when a bulk action is being triggered... 
            $message='';
            $class='';                              
           
    }

    /** ************************************************************************
    * REQUIRED! This is where you prepare your data for display. This method will
    * usually be used to query the database, sort and filter the data, and generally
    * get it ready to be displayed. At a minimum, we should set $this->items and
    * $this->set_pagination_args(), although the following properties and methods
    * are frequently interacted with here...
    * 
    * @global WPDB $wpdb
    * @uses $this->_column_headers
    * @uses $this->items
    * @uses $this->get_columns()
    * @uses $this->get_sortable_columns()
    * @uses $this->get_pagenum()
    * @uses $this->set_pagination_args()
    **************************************************************************/
    function prepare_items() {
         
        global $wpdb; //This is used only if making any database queries

        /**
        * First, lets decide how many records per page to show
        */
        $per_page = 10;


        /**
        * REQUIRED. Now we need to define our column headers. This includes a complete
        * array of columns to be displayed (slugs & titles), a list of columns
        * to keep hidden, and a list of columns that are sortable. Each of these
        * can be defined in another method (as we've done here) before being
        * used to build the value for our _column_headers property.
        */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();


        /**
        * REQUIRED. Finally, we build an array to be used by the class for column 
        * headers. The $this->_column_headers property takes an array which contains
        * 3 other arrays. One for all columns, one for hidden columns, and one
        * for sortable columns.
        */
        $this->_column_headers = array($columns, $hidden, $sortable);


        /**
        * Optional. You can handle your bulk actions however you see fit. In this
        * case, we'll handle them within our package just to keep things clean.
        */
        $this->process_bulk_action();


        /**
        * Instead of querying a database, we're going to fetch the example data
        * property we created for use in this plugin. This makes this example 
        * package slightly different than one you might build on your own. In 
        * this example, we'll be using array manipulation to sort and paginate 
        * our data. In a real-world implementation, you will probably want to 
        * use sort and pagination data to build a custom query instead, as you'll
        * be able to use your precisely-queried data immediately.
        */
        $data = $this->table_data;


        /**
        * This checks for sorting input and sorts the data in our array accordingly.
        * 
        * In a real-world situation involving a database, you would probably want 
        * to handle sorting by passing the 'orderby' and 'order' values directly 
        * to a custom query. The returned data will be pre-sorted, and this array
        * sorting technique would be unnecessary.
        */
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'id'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
            if(is_numeric($a[$orderby]) && is_numeric($b[$orderby])){
               $result = $a[$orderby]-$b[$orderby];
            }else{
                $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            }
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');


        /***********************************************************************
        * ---------------------------------------------------------------------
        * vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
        * 
        * In a real-world situation, this is where you would place your query.
        *
        * For information on making queries in WordPress, see this Codex entry:
        * http://codex.wordpress.org/Class_Reference/wpdb
        * 
        * ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
        * ---------------------------------------------------------------------
        **********************************************************************/


        /**
        * REQUIRED for pagination. Let's figure out what page the user is currently 
        * looking at. We'll need this later, so you should always include it in 
        * your own package classes.
        */
        $current_page = $this->get_pagenum();

        /**
        * REQUIRED for pagination. Let's check how many items are in our data array. 
        * In real-world use, this would be the total number of items in your database, 
        * without filtering. We'll need this later, so you should always include it 
        * in your own package classes.
        */
        $total_items = count($data);


        /**
        * The WP_List_Table class does not handle pagination for us, so we need
        * to ensure that the data is trimmed to only the current page. We can use
        * array_slice() to 
        */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);



        /**
        * REQUIRED. Now we can add our *sorted* data to the items property, where 
        * it can be used by the rest of the class.
        */
        $this->items = $data;

       // echo '<pre>';print_r($this->items);echo '</pre>';
        /**
        * REQUIRED. We also have to register our pagination options & calculations.
        */
        $this->set_pagination_args( array(
        'total_items' => $total_items,                  //WE have to calculate the total number of items
        'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
        'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}
