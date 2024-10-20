<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_inventory_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->db3=$this->load->database('inventory',true);

           // if(!empty($this->db3))
           //         echo "Connected!"."\n";
           // else
           //         echo "Closed"."\n";

           //  die();
		
	}

	function get_supplier_other_db()
	{
		// print_r($this->db3);
		// die();
		$this->db3->select('
            SUPPLIERID as       dist_distributorid,
			SUPPLIERNAME 		as  dist_distributor,
            SUPPLIERADDRESS  	as 	dist_address1,
            SUPPLIERPHONE  		as  dist_phone1,
            SUPPLIERMOBILE  	as 	dist_phone2,
            CONTACTPERSON  		as  dist_salesrep,
            SUPPLIERFAX  		as 	dist_fax,
            SUPPLIERMAIL  		as  dist_email,
            GOVTREGNO  			as 	dist_govtregno,
            GOVTREGDATE  		as 	dist_govtregdatead,
            REMARKS  			as  dist_remarks,
            SUPPLIERCODE  		as  dist_distributorcode,
            CITY   				as  dist_city,
            STREET   			as  dist_address1
			');
		$this->db3->order_by('SUPPLIERID','ASC');
		$query=$this->db3->get('SUPPLIER');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}

    public function get_department_other_db()
    {
        $this->db3->select('
            DEPID   as dept_depid, 
            DEPCODE as dept_depcode, 
            DEPNAME as dept_depname,
            PARENTID as dept_parentdepid
            ');
        $this->db3->order_by('DEPID','ASC');
        $query=$this->db3->get('DEPARTMENT');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }

    

	public function get_purchase_item_list()
	{
		$result=$this->db3->query("SELECT A.*,(Required_Qty*UnitPrice) Total FROM
			(
       	(SELECT MTD.ItemsID,ItemsCode,ItemsName,AssetQuantity(Mat_Trans_DetailID) Required_Qty,
        MTM.Transaction_Date, Mat_Trans_DetailID,MTD.UnitPrice,TO_DepartmentID,IL.CatID,S.SupplierID,
        CatCode, CategoryName, InvoiceNo ReceiveNo,
        D.DepartmentName Department,
        S.SupplierName Supplier, substr(mtd.DESCRIPTION,1,255) DESCRIPTION, mtd.DESCRIPTION DESCRIPTIONFull,
        RM.Status Master_Status, RM.BudgetID
        FROM Mat_Trans_Master MTM,Mat_Trans_Detail MTD,ItemsList IL,Category C,
        ReceivedDetail RD, ReceivedMaster RM, Counter D, Supplier S
        WHERE MTM.Mat_Trans_MasterID=MTD.Mat_Trans_MasterID
        AND RD.ReceivedDetailID=MTD.MTDID
        AND RM.ReceivedMasterID=RD.ReceivedMasterID
        AND MTM.To_DepartmentID=D.DepartmentID(+)
        AND RM.SUPPLIERID=S.SupplierID(+)
        AND MTD.ItemsID=Il.ItemsID AND IL.CatID=C.CategoryID(+)
        AND UPPER(MTM.Transaction_Type) = 'PURCHASE'
        AND MTM.Status='O'
        AND (IL.TypeAID=(SELECT TypeID FROM MaterialType WHERE NonExpandable='Y'))
       )
       UNION
       (SELECT MTD.ItemsID,ItemsCode,ItemsName,AssetQuantity(Mat_Trans_DetailID) Required_Qty,
            MTD.Transaction_Date, Mat_Trans_DetailID,MTD.UnitPrice,TO_DepartmentID,IL.CatID, 0 SupplierID,
        CatCode, CategoryName,'N/A' ReceiveNo, mtd.DESCRIPTION DESCRIPTIONFull,
        D.DepartmentName Department, ' ' Supplier, SubStr(mtd.DESCRIPTION,1,255) DESCRIPTION, 'O' Master_Status, 0 BudgetID
        FROM Mat_Trans_Master MTM,Mat_Trans_Detail MTD,ItemsList IL,Category C, Counter D
        WHERE MTM.Mat_Trans_MasterID=MTD.Mat_Trans_MasterID
        AND MTM.To_DepartmentID=D.DepartmentID(+)
        AND MTD.ItemsID=Il.ItemsID AND IL.CatID=C.CategoryID
        AND UPPER(MTM.Transaction_Type) = 'OPENING'
        AND MTM.Status='O'
        AND (IL.TypeAID=(SELECT TypeID FROM MaterialType WHERE NonExpandable='Y')))
)A
WHERE Master_Status<>'M' AND Required_Qty>0
ORDER BY Transaction_Date")->result();
		// $query=$this->db3->get();
		// echo $this->db3->last_query();
		// die();
		return $result;


		
	}





	
	

    
}
        
                
                 
                
                
              
               
                     
                  
            
    
                
               
                    
                
                
                     
                   