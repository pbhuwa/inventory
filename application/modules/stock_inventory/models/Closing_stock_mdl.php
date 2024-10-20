<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Closing_stock_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->username = $this->session->userdata(USER_NAME);
	}
	public function generate_closing_stock_record()
	{
		try{
			$postdata=$this->input->post();
			$store = !empty($this->input->post('store'))?$this->input->post('store'):'';
			$fromdate  = $this->input->post('fromdate');
			$todate = $this->input->post('todate');
			if(DEFAULT_DATEPICKER=='NP')
            {
                $fromdateNp=$fromdate;
                $fromdateEn=$this->general->NepToEngDateConv($fromdate);
                $todateNp=$todate;
                $todateEn=$this->general->NepToEngDateConv($todate);
            }
            else
            {
                $fromdateEn=$fromdate;
                $fromdateNp=$this->general->EngToNepDateConv($fromdate);
                $todateEn=$todate;
                $todateNp=$this->general->EngToNepDateConv($todate);
            }
            $this->db->trans_begin();
            $closing_details=array();
            $clsmarray = array(
            					'clsm_departmentid'=>$store,
							    'clsm_complete'=>'Y',
							    'clsm_generatetime'=>$this->general->get_currenttime(),
							    'clsm_fromdatebs'=>$fromdateNp,
							    'clsm_fromdatead'=>$fromdateEn,
							    'clsm_todatebs'=>$todateEn,
							    'clsm_todatead'=>$todateNp,
							    'clsm_generatedatead'=>CURDATE_EN,
					    		'clsm_generatedatebs'=>CURDATE_NP,
							    'clsm_username'=>$this->username,
							    'clsm_locationid'=> $this->locationid,
            				);
		    //echo "<pre>";print_r($clsmarray);die();
		    if(!empty($clsmarray))
		    {
		      	$this->db->insert('clsm_closingstockmaster',$clsmarray);
		      	//echo $this->db->last_query();die;
		      	$insertid=$this->db->insert_id();
			    if($insertid)
			    {	//return $insertid;
			    	// $query = $this->db->query("CALL generateClosingStore('$fromdate','$todate','$store')");
		   //          if($query->num_rows() > 0) 
					// {
					// 	$datadetails=$query->result();
					// }
					$datadetails=$this->close_stock_detail($fromdate,$todate);
						// echo"<pre>"; print_r($datadetails);die;

					foreach ($datadetails as $key => $value) {
						$closing_details[] = array(
											//'csde_csdetailid'=>$insertid,
												'csde_itemsid'=>!empty($value->itli_itemlistid)?$value->itli_itemlistid:0,
												'csde_purchasedqty'=>!empty($value->PURCHASEDQTY)?$value->PURCHASEDQTY:0,
												'csde_purchasedvalue'=>!empty($value->PURCHASEDVALUE)?$value->PURCHASEDVALUE:0,
												'csde_returnqty'=>!empty($value->PRETURNQTY)?$value->PRETURNQTY:0,
												'csde_preturnvalue'=>!empty($value->PRETURNVALUE)?$value->PRETURNVALUE:0,
												'csde_soldqty'=>!empty($value->SOLDQTY)?$value->SOLDQTY:0,
												'csde_soldvalue'=>!empty($value->SOLDVALUE)?$value->SOLDVALUE:0,
												'csde_soldpurvalue'=>!empty($value->SOLDPURVALUE)?$value->SOLDPURVALUE:0,
												'csde_sreturnqty'=>!empty($value->SRETURNQTY)?$value->SRETURNQTY:0,
												'csde_sreturnvalue'=>!empty($value->SRETURNVALUE)?$value->SRETURNVALUE:0,
												'csde_sreturnpvalue'=>!empty($value->SRETURNPVALUE)?$value->SRETURNPVALUE:0,
												'csde_stockqty'=>!empty($value->STOCKQTY)?$value->STOCKQTY:0,
												'csde_stockvalue'=>!empty($value->STOCKVALUE)?$value->STOCKVALUE:0,
												'csde_csmamasterid'=>$insertid,
												'csde_issueqty'=>!empty($value->ISSUEQTY)?$value->ISSUEQTY:0,
												'csde_issueamount'=>!empty($value->ISSUEAMT)?$value->ISSUEAMT:0,
												'csde_receivedqty'=>!empty($value->RECEIVEDQTY)?$value->RECEIVEDQTY:0,
												'csde_receivedamnt'=>!empty($value->RECEIVEDAMT)?$value->RECEIVEDAMT:0,
												'csde_openingqty'=>!empty($value->OPENINGQTY)?$value->OPENINGQTY:0,
												'csde_openingamt'=>!empty($value->OPENINGAMT)?$value->OPENINGAMT:0,
												'csde_curopeningqty'=>!empty($value->OPQTY)?$value->OPQTY:0,
												'csde_curopeningamt'=>!empty($value->OPCOSTAMT)?$value->OPCOSTAMT:0,
												'csde_transactionqty'=>!empty($value->TRANSACTIONQTY)?$value->TRANSACTIONQTY:0,
												'csde_transactionvalue'=>!empty($value->TRANSACTIONVALUE)?$value->TRANSACTIONVALUE:0,
												'csde_adjqty'=>!empty($value->ADJQTY)?$value->ADJQTY:0,
												'csde_adjvalue'=>!empty($value->ADJVALUE)?$value->ADJVALUE:0,
											//'csde_mtdqty'=>!empty($value->)?,
												'csde_conqty'=>!empty($value->OUTCONQTY)?$value->OUTCONQTY:0,
												'csde_convalue'=>!empty($value->OUTCONCOSTAMT)?$value->OUTCONCOSTAMT:0,
												'csde_incconqty'=>!empty($value->INCCONQTY)?$value->INCCONQTY:0,
												'csde_incconvalue'=>!empty($value->INCCONVALUE)?$value->INCCONVALUE:0,
												//'csde_mtdvalue'=>!empty($value->)?,
												'csde_challanqty'=>!empty($value->CHALANQTY)?$value->CHALANQTY:0,
												'csde_locationid'=>!empty($this->locationi)?$this->locationi:0

											);
						// $this->db->insert('csde_closingstockdetail',$closing_details);
						// echo $this->db->last_query();
						// die();	
					}
					// echo "<pre>";
					// print_r($closing_details);
					// die();
					

						if(!empty($closing_details))
	                        {   
	                        // echo"<pre>";print_r($closing_details);die;
	                            $this->db->insert_batch('csde_closingstockdetail',$closing_details);
	                            // echo $this->db->last_query();die;
	                            $this->db->update('clsm_closingstockmaster',array('clsm_complete'=>'Y'),array('clsm_csmasterid'=>$insertid));
	                        }	
					//}
			    }
		    }
		    $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
            	$this->db->update('clsm_closingstockmaster',array('clsm_complete'=>'N'),array('clsm_csmasterid'=>$insertid));
                $this->db->trans_rollback();
                return false;
            }
            else{
                $this->db->trans_commit();
                return true;
            }
		return false;
        }catch(Exception $e){
            throw $e;
        }
	}

	public function close_stock_detail($fromDate,$toDate)
	{
				$sql="SELECT 
					itli_itemlistid,
					sum(PURQTY) PURCHASEDQTY,
					sum(PURCOSTAMT) PURCHASEDVALUE,
					sum(PURRETQTY) PRETURNQTY,
					sum(PURRETCOSTAMT) PRETURNVALUE,
					sum(PURRETSALEAMT) PRETURNSALESVALUE,
					sum(ISSQTY) SOLDQTY,
					sum(ISSCOSTAMT) SOLDVALUE,
					sum(ISSSALEAMT) SOLDPURVALUE,
					sum(ISSRETQTY) SRETURNQTY,
					sum(ISSRETCOSTAMT) SRETURNVALUE,
					sum(ISSRETSALEAMT) SRETURNPVALUE,
					SUM(STOCKQTY) STOCKQTY,
					SUM( STOCKVALUE)STOCKVALUE,
					SUM(RecAmtQty)RECEIVEDQTY,
					SUM(RecAmtAmt) RECEIVEDAMT,
					SUM(RecAmtSaleAmt)RECEIVEDSALESAMT,
					SUM(STOCKQTY+ISSQTY-PURQTY) OPENINGQTY,
					SUM(ISSCOSTAMT+STOCKVALUE-PURCOSTAMT) OPENINGAMT,
					sum(IssAmtQty)ISSUEQTY, 
					SUM(IssAmtAmt)ISSUEAMT,
					SUM(IssAmtSaleAmt)IssAmtSaleAmt,
					sum(OPQty) OPQTY,
					sum(OPCostAmt) OPCOSTAMT,
					sum(OPSALEAMT) OPSALEAMT,
					sum(PURSALEAMT) PURSALEAMT,
					sum(OUTCONQTY) OUTCONQTY,
					sum(OUTCONCOSTAMT) OUTCONCOSTAMT,
					sum(INCONQTY) INCCONQTY,
					sum(INCONCOSTAMT) INCCONVALUE,
					sum(StkAdjQty) ADJQTY ,
					sum(StkAdjCostAmt) ADJVALUE,
					sum(StkAdjSaleAmt)ADJVALUESaleAmt , 
					sum(AdjAmt) AdjAmt,
					SUM(InTranQty)TRANSACTIONQTY ,
					SUM(InTranCostAmt) TRANSACTIONVALUE,
					SUM( CHALANQTY)CHALANQTY
		 FROM xw_itli_itemslist il LEFT JOIN 
				(  -- opening  value   il.itli_itemlistid,  this is implemented at last 
					SELECT
					mtd.trde_itemsid as itemsid,
					SUM(mtd.trde_requiredqty) AS OPQty,
					SUM(mtd.trde_requiredqty * mtd.trde_unitprice) AS OPCostAmt,
					SUM(mtd.trde_requiredqty * mtd.trde_selprice) AS OPSaleAmt,
					0 AS PurQty,
					0 AS PurCostAmt,
					0 AS PurSaleAmt,
					0 AS PurRetQty,
					0 AS PurRetCostAmt,
					0 AS PurRetSaleAmt,
					0 IssQty,
					0 IssCostAmt,
					0 IssSaleAmt,
					0 IssRetQty,
					0 IssRetCostAmt,
					0 IssRetSaleAmt,
					0 OutConQty,
					0 OutConCostAmt,
					0 InConQty,
					0 InConCostAmt,
					0 StkAdjQty,
					0 StkAdjCostAmt,
					0 StkAdjSaleAmt,
					0 AdjAmt,
					0 AS IssAmtQty,
					0 AS IssAmtAmt,
					0 AS IssAmtSaleAmt,
					0 RecAmtQty,
					0 RecAmtAmt,
					0 RecAmtSaleAmt,
					0 InTranQty,
					0 InTranCostAmt,
					0 STOCKQTY,
					0 STOCKVALUE,
					0 CHALANQTY
				FROM
					xw_trma_transactionmain mtm
				LEFT JOIN xw_trde_transactiondetail mtd ON mtd.trde_trmaid = mtm.trma_trmaid
				WHERE
					UPPER(mtm.trma_transactiontype) = 'OPENING'
				AND mtm.trma_transactiondatebs BETWEEN '".$fromDate."'
				AND '".$toDate."'
				AND mtm.trma_status = 'O'
				GROUP BY mtd.trde_itemsid
				-- Purchase  value 
					UNION
						SELECT
							rd.recd_itemsid as itemsid,
							0 AS OPQty,
							0 AS OPCostAmt,
							0 AS OPSaleAmt,
							SUM(rd.recd_purchasedqty) AS PurQty,
							SUM(rd.recd_purchasedqty * rd.recd_unitprice) AS PurCostAmt, -- arate is not used so replace by unitprice
							SUM(rd.recd_purchasedqty * rd.recd_salerate) AS PurSaleAmt,
							0 AS PurRetQty,
							0 AS PurRetCostAmt,
							0 AS PurRetSaleAmt,
							0 IssQty,
							0 IssCostAmt,
							0 IssSaleAmt,
							0 IssRetQty,
							0 IssRetCostAmt,
							0 IssRetSaleAmt,
							0 OutConQty,
							0 OutConCostAmt,
							0 InConQty,
							0 InConCostAmt,
							0 StkAdjQty,
							0 StkAdjCostAmt,
							0 StkAdjSaleAmt,
							0 AdjAmt,
							0 AS IssAmtQty,
							0 AS IssAmtAmt,
							0 AS IssAmtSaleAmt,
							0 RecAmtQty,
							0 RecAmtAmt,
							0 RecAmtSaleAmt,
							0 InTranQty,
							0 InTranCostAmt,
							0 STOCKQTY,
							0 STOCKVALUE,
							0 CHALANQTY
						FROM
								xw_recm_receivedmaster rm
						LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_receivedmasterid = rm.recm_receivedmasterid
						WHERE rm.recm_status = 'O'
						AND rm.recm_receiveddatebs BETWEEN '".$fromDate."' AND '".$toDate."'
						GROUP BY rd.recd_itemsid
					UNION
					-- purchase return value 
						SELECT
							prd.prde_itemsid AS itemsid,
							0 AS OPQty,
							0 AS OPCostAmt,
							0 AS OPSaleAmt,
							0 AS PurQty,
							0 AS PurCostAmt, -- arate is not used so replace by unitprice
							0 AS PurSaleAmt,
							SUM(prd.prde_returnqty) AS PurRetQty,
							SUM(prd.prde_returnqty * prd.prde_purchaserate) AS PurRetCostAmt,
							0 AS PurRetSaleAmt,
							0 IssQty,
							0 IssCostAmt,
							0 IssSaleAmt,
							0 IssRetQty,
							0 IssRetCostAmt,
							0 IssRetSaleAmt,
							0 OutConQty,
							0 OutConCostAmt,
							0 InConQty,
							0 InConCostAmt,
							0 StkAdjQty,
							0 StkAdjCostAmt,
							0 StkAdjSaleAmt,
							0 AdjAmt,
							0 AS IssAmtQty,
							0 AS IssAmtAmt,
							0 AS IssAmtSaleAmt,
							0 RecAmtQty,
							0 RecAmtAmt,
							0 RecAmtSaleAmt,
							0 InTranQty,
							0 InTranCostAmt,
							0 STOCKQTY,
							0 STOCKVALUE,
							0 CHALANQTY
						FROM
								xw_purr_purchasereturn pr
						LEFT JOIN xw_prde_purchasereturndetail prd ON prd.prde_purchasereturnid = pr.purr_purchasereturnid
						WHERE pr.purr_returndatebs BETWEEN '".$fromDate."' AND '".$toDate."'
						AND pr.purr_st='N'
						GROUP BY prd.prde_itemsid
						-- Issue Qty 
					UNION
					SELECT
							sd.sade_itemsid AS itemsid,
							0 AS OPQty,
							0 AS OPCostAmt,
							0 AS OPSaleAmt,
							0 AS PurQty,
							0 AS PurCostAmt, 
							0 AS PurSaleAmt,
							0 AS PurRetQty,
							0 AS PurRetCostAmt,
							0 AS PurRetSaleAmt,
							SUM(sd.sade_qty) AS IssQty,
							SUM(sd.sade_qty * sd.sade_unitrate) AS IssCostAmt,
							SUM(sd.sade_qty * sd.sade_unitrate) AS IssSaleAmt,
							0 IssRetQty,
							0 IssRetCostAmt,
							0 IssRetSaleAmt,
							0 OutConQty,
							0 OutConCostAmt,
							0 InConQty,
							0 InConCostAmt,
							0 StkAdjQty,
							0 StkAdjCostAmt,
							0 StkAdjSaleAmt,
							0 AdjAmt,
							0 AS IssAmtQty,
							0 AS IssAmtAmt,
							0 AS IssAmtSaleAmt,
							0 RecAmtQty,
							0 RecAmtAmt,
							0 RecAmtSaleAmt,
							0 InTranQty,
							0 InTranCostAmt,
							0 STOCKQTY,
							0 STOCKVALUE,
							0 CHALANQTY
						FROM
								xw_sama_salemaster sm
						LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
						WHERE sm.sama_billdatebs BETWEEN '".$fromDate."' AND '".$toDate."'
						AND sm.sama_st='N'
						GROUP BY sd.sade_itemsid
					UNION
					-- Issue retuen Qty
						SELECT
								rd.rede_itemsid AS itemsid,
								0 AS OPQty,
								0 AS OPCostAmt,
								0 AS OPSaleAmt,
								0 AS PurQty,
								0 AS PurCostAmt,
								0 AS PurSaleAmt,
								0 AS PurRetQty,
								0 AS PurRetCostAmt,
								0 AS PurRetSaleAmt,
								0 AS IssQty,
								0 AS IssCostAmt,
								0 AS IssSaleAmt,
								SUM(rd.rede_qty) AS IssRetQty,
								SUM(rd.rede_qty * rd.rede_unitprice) AS  IssRetCostAmt,  -- arate is not used so replace by unitprice
								SUM(rd.rede_qty * rd.rede_unitprice) AS IssRetSaleAmt,
								0 OutConQty,
								0 OutConCostAmt,
								0 InConQty,
								0 InConCostAmt,
								0 StkAdjQty,
								0 StkAdjCostAmt,
								0 StkAdjSaleAmt,
								0 AdjAmt,
								0 AS IssAmtQty,
								0 AS IssAmtAmt,
								0 AS IssAmtSaleAmt,
								0 RecAmtQty,
								0 RecAmtAmt,
								0 RecAmtSaleAmt,
								0 InTranQty,
								0 InTranCostAmt,
								0 STOCKQTY,
								0 STOCKVALUE,
								0 CHALANQTY
							FROM
									xw_rema_returnmaster rtm
							LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rtm.rema_returnmasterid
							WHERE rtm.rema_returndatebs BETWEEN '".$fromDate."' AND '".$toDate."'
							AND rtm.rema_st='N'
						GROUP BY rd.rede_itemsid
					-- out conversion
					UNION 
					SELECT  
								conv_parentid AS itemsid,
								0 AS OPQty,
								0 AS OPCostAmt,
								0 AS OPSaleAmt,
								0 AS PurQty,
								0 AS PurCostAmt,
								0 AS PurSaleAmt,
								0 AS PurRetQty,
								0 AS PurRetCostAmt,
								0 AS PurRetSaleAmt,
								0 AS IssQty,
								0 AS IssCostAmt,
								0 AS IssSaleAmt,
								0 AS IssRetQty,
								0 AS IssRetCostAmt, 
								0 AS IssRetSaleAmt,
								SUM(conv_parentqty) AS OutConQty,
								SUM(conv_parentqty * conv_parentrate) AS OutConCostAmt,
								0 AS InConQty,
								0 AS InConCostAmt,
								0 AS StkAdjQty,
								0 AS StkAdjCostAmt,
								0 AS StkAdjSaleAmt,
								0 AS AdjAmt,
								0 AS IssAmtQty,
								0 AS IssAmtAmt,
								0 AS IssAmtSaleAmt,
								0 AS RecAmtQty,
								0 AS RecAmtAmt,
								0 AS RecAmtSaleAmt,
								0 AS InTranQty,
								0 AS InTranCostAmt,
								0 AS STOCKQTY,
								0 AS STOCKVALUE,
								0 AS CHALANQTY
							FROM
									xw_conv_conversion 
							WHERE conv_condatebs BETWEEN '".$fromDate."' AND '".$toDate."'
						GROUP BY conv_parentid
				-- in conversion
					UNION
					SELECT 
								conv_childid AS itemsid,
								0 AS OPQty,
								0 AS OPCostAmt,
								0 AS OPSaleAmt,
								0 AS PurQty,
								0 AS PurCostAmt,
								0 AS PurSaleAmt,
								0 AS PurRetQty,
								0 AS PurRetCostAmt,
								0 AS PurRetSaleAmt,
								0 AS IssQty,
								0 AS IssCostAmt,
								0 AS IssSaleAmt,
								0 AS IssRetQty,
								0 AS IssRetCostAmt, 
								0 AS IssRetSaleAmt,
								0 AS OutConQty,
								0 AS OutConCostAmt,
								SUM(conv_childqty) AS InConQty,
								SUM(conv_parentqty * conv_childrate) AS InConCostAmt,
								0 AS StkAdjQty,
								0 AS StkAdjCostAmt,
								0 AS StkAdjSaleAmt,
								0 AS AdjAmt,
								0 AS IssAmtQty,
								0 AS IssAmtAmt,
								0 AS IssAmtSaleAmt,
								0 AS RecAmtQty,
								0 AS RecAmtAmt,
								0 AS RecAmtSaleAmt,
								0 AS InTranQty,
								0 AS InTranCostAmt,
								0 AS STOCKQTY,
								0 AS STOCKVALUE,
								0 AS CHALANQTY
							FROM
									xw_conv_conversion 
							WHERE conv_condatebs BETWEEN '".$fromDate."' AND '".$toDate."'
						GROUP BY conv_childid
				-- Stock Adjustment and Adjustment Amount 
				UNION
					SELECT 
								std.stde_itemsid AS itemsid,
								0 AS OPQty,
								0 AS OPCostAmt,
								0 AS OPSaleAmt,
								0 AS PurQty,
								0 AS PurCostAmt,
								0 AS PurSaleAmt,
								0 AS PurRetQty,
								0 AS PurRetCostAmt,
								0 AS PurRetSaleAmt,
								0 AS IssQty,
								0 AS IssCostAmt,
								0 AS IssSaleAmt,
								0 AS IssRetQty,
								0 AS IssRetCostAmt, 
								0 AS IssRetSaleAmt,
								0 AS OutConQty,
								0 AS OutConCostAmt,
								0 AS InConQty,
								0 AS InConCostAmt,
								SUM(std.stde_qty) AS StkAdjQty,
								SUM(std.stde_qty * std.stde_rate) AS StkAdjCostAmt,
								SUM(std.stde_qty * std.stde_salerate) AS StkAdjSaleAmt,
								0 AS AdjAmt,
								0 AS IssAmtQty,
								0 AS IssAmtAmt,
								0 AS IssAmtSaleAmt,
								0 AS RecAmtQty,
								0 AS RecAmtAmt,
								0 AS RecAmtSaleAmt,
								0 AS InTranQty,
								0 AS InTranCostAmt,
								0 AS STOCKQTY,
								0 AS STOCKVALUE,
								0 AS CHALANQTY
							FROM xw_stma_stockmaster stm
							LEFT JOIN xw_stde_stockdetail std ON std.stde_stockmasterid = stm.stma_stockmassterid
							WHERE stm.stma_stockdatebs BETWEEN '".$fromDate."' AND '".$toDate."'
						GROUP BY std.stde_itemsid
				-- Issued Amt
				UNION
					SELECT
					mtd.trde_itemsid as itemsid,
					0 AS OPQty,
					0 AS OPSaleAmt,
					0 AS PurQty,
					0 AS PurCostAmt,
					0 AS PurCostAmt,
					0 AS PurSaleAmt,
					0 AS PurRetQty,
					0 AS PurRetCostAmt,
					0 AS PurRetSaleAmt,
					0 IssQty,
					0 IssCostAmt,
					0 IssSaleAmt,
					0 IssRetQty,
					0 IssRetCostAmt,
					0 IssRetSaleAmt,
					0 OutConQty,
					0 OutConCostAmt,
					0 InConQty,
					0 InConCostAmt,
					0 StkAdjQty,
					0 StkAdjCostAmt,
					0 StkAdjSaleAmt,
					0 AdjAmt,
					SUM(mtd.trde_requiredqty) AS IssAmtQty,
					SUM(mtd.trde_requiredqty * mtd.trde_unitprice) AS IssAmtAmt,
					SUM(mtd.trde_requiredqty * mtd.trde_selprice) AS IssAmtSaleAmt,
					0 AS RecAmtQty,
					0 AS RecAmtAmt,
					0 AS RecAmtSaleAmt,
					0 AS InTranQty,
					0 AS InTranCostAmt,
					0 AS STOCKQTY,
					0 AS STOCKVALUE,
					0 AS CHALANQTY
				FROM
					xw_trma_transactionmain mtm
				LEFT JOIN xw_trde_transactiondetail mtd ON mtd.trde_trmaid = mtm.trma_trmaid
				WHERE
					UPPER(mtm.trma_transactiontype) = 'ISSUE'
				 AND mtm.trma_transactiondatebs BETWEEN '".$fromDate."' AND '".$toDate."' AND mtm.trma_status = 'O'
				GROUP BY mtd.trde_itemsid
				-- Receive Amt
				UNION 
					SELECT
					mtd.trde_itemsid AS itemsid,
					0 AS OPQty,
					0 AS OPCostAmt,
					0 AS OPSaleAmt,
					0 AS PurQty,
					0 AS PurCostAmt,
					0 AS PurSaleAmt,
					0 AS PurRetQty,
					0 AS PurRetCostAmt,
					0 AS PurRetSaleAmt,
					0 IssQty,
					0 IssCostAmt,
					0 IssSaleAmt,
					0 IssRetQty,
					0 IssRetCostAmt,
					0 IssRetSaleAmt,
					0 OutConQty,
					0 OutConCostAmt,
					0 InConQty,
					0 InConCostAmt,
					0 StkAdjQty,
					0 StkAdjCostAmt,
					0 StkAdjSaleAmt,
					0 AdjAmt,
					0 IssAmtQty,
					0 AS IssAmtAmt,
					0 AS IssAmtSaleAmt,
					SUM(mtd.trde_requiredqty) AS RecAmtQty,
					SUM(mtd.trde_requiredqty * mtd.trde_unitpercase) AS RecAmtAmt,
					SUM(mtd.trde_requiredqty * mtd.trde_selprice) AS RecAmtSaleAmt,
					0 AS InTranQty,
					0 AS InTranCostAmt,
					0 AS STOCKQTY,
					0 AS STOCKVALUE,
					0 AS CHALANQTY
				FROM
					xw_trma_transactionmain mtm
				LEFT JOIN xw_trde_transactiondetail mtd ON mtd.trde_trmaid = mtm.trma_trmaid
				WHERE
					UPPER(mtm.trma_transactiontype) = 'ISSUE'
				 AND mtm.trma_transactiondatebs BETWEEN '".$fromDate."' AND '".$toDate."' AND mtm.trma_status = 'O'
				 AND mtm.trma_received='1' 
				 GROUP BY mtd.trde_itemsid
				-- Amt InTrans
				UNION 
					SELECT
						mtd.trde_itemsid AS itemsid,
						0 AS OPQty,
						0 AS OPCostAmt,
						0 AS OPSaleAmt,
						0 AS PurQty,
						0 AS PurCostAmt,
						0 AS PurSaleAmt,
						0 AS PurRetQty,
						0 AS PurRetCostAmt,
						0 AS PurRetSaleAmt,
						0 IssQty,
						0 IssCostAmt,
						0 IssSaleAmt,
						0 IssRetQty,
						0 IssRetCostAmt,
						0 IssRetSaleAmt,
						0 OutConQty,
						0 OutConCostAmt,
						0 InConQty,
						0 InConCostAmt,
						0 StkAdjQty,
						0 StkAdjCostAmt,
						0 StkAdjSaleAmt,
						0 AdjAmt,
						0 IssAmtQty,
						0 AS IssAmtAmt,
						0 AS IssAmtSaleAmt,
						0 AS RecAmtQty,
						0 AS RecAmtAmt,
						0 AS RecAmtSaleAmt,
						SUM(mtd.trde_requiredqty) AS InTranQty,
						SUM(mtd.trde_requiredqty * mtd.trde_unitprice) AS InTranCostAmt,
						0 AS STOCKQTY,
						0 AS STOCKVALUE,
						0 AS CHALANQTY
					FROM
						xw_trma_transactionmain mtm
					LEFT JOIN xw_trde_transactiondetail mtd ON mtd.trde_trmaid = mtm.trma_trmaid
					WHERE
						UPPER(mtm.trma_transactiontype) = 'ISSUE' AND mtm.trma_transactiondatebs BETWEEN '".$fromDate."' AND '".$toDate."' 
					 AND mtm.trma_status = 'O'
					 AND mtm.trma_received='0' 
					 GROUP BY mtd.trde_itemsid
				-- OVERALL STOCK 
				UNION
					SELECT
						mtd.trde_itemsid AS itemsid,
						0 AS OPQty,
						0 AS OPCostAmt,
						0 AS OPSaleAmt,
						0 AS PurQty,
						0 AS PurCostAmt,
						0 AS PurSaleAmt,
						0 AS PurRetQty,
						0 AS PurRetCostAmt,
						0 AS PurRetSaleAmt,
						0 IssQty,
						0 IssCostAmt,
						0 IssSaleAmt,
						0 IssRetQty,
						0 IssRetCostAmt,
						0 IssRetSaleAmt,
						0 OutConQty,
						0 OutConCostAmt,
						0 InConQty,
						0 InConCostAmt,
						0 StkAdjQty,
						0 StkAdjCostAmt,
						0 StkAdjSaleAmt,
						0 AdjAmt,
						0 IssAmtQty,
						0 AS IssAmtAmt,
						0 AS IssAmtSaleAmt,
						0 AS RecAmtQty,
						0 AS RecAmtAmt,
						0 AS RecAmtSaleAmt,
						0 AS InTranQty,
						0 AS InTranCostAmt,
						SUM(mtd.trde_issueqty) AS STOCKQTY,
						SUM(mtd.trde_issueqty * mtd.trde_unitprice) AS STOCKVALUE,
						0 AS CHALANQTY
					FROM
						xw_trma_transactionmain mtm
					LEFT JOIN xw_trde_transactiondetail mtd ON mtd.trde_trmaid = mtm.trma_trmaid
					WHERE UPPER(mtm.trma_transactiontype) = 'ISSUE'
					 AND mtm.trma_transactiondatebs BETWEEN '".$fromDate."' AND '".$toDate."' AND mtm.trma_status = 'O'
					 AND mtm.trma_received='0' 
					 GROUP BY mtd.trde_itemsid
				-- CHALLAN QTY
				UNION
					SELECT
							cd.chde_itemsid AS itemsid,
							0 AS OPQty,
							0 AS OPCostAmt,
							0 AS OPSaleAmt,
							0 AS PurQty,
							0 AS PurCostAmt,
							0 AS PurSaleAmt,
							0 AS PurRetQty,
							0 AS PurRetCostAmt,
							0 AS PurRetSaleAmt,
							0 IssQty,
							0 IssCostAmt,
							0 IssSaleAmt,
							0 IssRetQty,
							0 IssRetCostAmt,
							0 IssRetSaleAmt,
							0 OutConQty,
							0 OutConCostAmt,
							0 InConQty,
							0 InConCostAmt,
							0 StkAdjQty,
							0 StkAdjCostAmt,
							0 StkAdjSaleAmt,
							0 AdjAmt,
							0 IssAmtQty,
							0 AS IssAmtAmt,
							0 AS IssAmtSaleAmt,
							0 AS RecAmtQty,
							0 AS RecAmtAmt,
							0 AS RecAmtSaleAmt,
							0 AS InTranQty,
							0 AS InTranCostAmt,
							0 AS STOCKQTY,
							0 AS STOCKVALUE,
							SUM(cd.chde_qty) AS CHALANQTY
						FROM
							xw_chma_challanmaster cm
						LEFT JOIN xw_chde_challandetails cd ON cd.chde_challanmasterid = cm.chma_challanmasterid
						WHERE cm.chma_challanrecdatebs BETWEEN '".$fromDate."' AND '".$toDate."'
					GROUP BY cd.chde_itemsid
		)X ON x.itemsid=il.itli_itemlistid
		GROUP BY il.itli_itemlistid, il.itli_itemname
		ORDER BY il.itli_itemlistid ASC";
		// echo $sql;
		// die();
		$result=$this->db->query($sql)->result();
		return $result;

	}
	public function get_closing_details_data($cond=false)
	{
		$locationid=$this->input->get('locationid');
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_3']."%'  ");
            $this->db->where("itli_itemname like  '%".$get['sSearch_3']."%' OR itli_itemnamenp like  '%".$get['sSearch_3']."%'  ");
        }
        // if(!empty($get['sSearch_4'])){
        //     $this->db->where("unit_unitname like  '%".$get['sSearch_4']."%'  ");
        // }
        // if(!empty($get['sSearch_5'])){
        //     $this->db->where("unit_unitname like  '%".$get['sSearch_5']."%'  ");
        // }
        // if(!empty($get['sSearch_6'])){
        //     $this->db->where("purd_qty like  '%".$get['sSearch_6']."%'  ");
        // }

        // // if(!empty($get['sSearch_7'])){
        // //     $this->db->where("redt_remaqty like  '%".$get['sSearch_7']."%'  ");
        // // }

        // if(!empty($get['sSearch_7'])){
        //     $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_7']."%'  ");
        // }
        
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $masterid = !empty($get['masterid'])?$get['masterid']:$this->input->post('masterid');

        if(!empty($masterid))
        {
            
            $this->db->where('cm.clsm_csmasterid',$masterid);
        }
      if($this->location_ismain=='Y'){
       if(!empty($locationid)){
	     $this->db->where('csde_locationid',$locationid);
          }
         }else{
          	$this->db->where('csde_locationid',$this->locationid);

        }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('csde_closingstockdetail cd')
                    ->join('clsm_closingstockmaster cm', 'cm.clsm_csmasterid = cd.csde_csmamasterid', "LEFT")
                    ->join('itli_itemslist il', 'il.itli_itemlistid = cd.csde_itemsid', "LEFT")
                    ->join('unit_unit u', 'u.unit_unitid = il.itli_unitid', "LEFT")
                    ->join('eqty_equipmenttype c', 'c.eqty_equipmenttypeid = il.itli_typeid', "LEFT")
                    ->get()
                    ->row();

      	//echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'clsm_fromdatebs';
      	$order = 'asc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==1)
        	$order_by = 'itli_itemcode';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'eqty_equipmenttype';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'itli_itemname';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'unit_unitname';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'csde_purchasedqty';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'csde_purchasedvalue';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'csde_preturnvalue';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'csde_soldqty';
        else if($this->input->get('iSortCol_0')==9)
       		$order_by = 'csde_soldvalue';
       	else if($this->input->get('iSortCol_0')==10)
      	 	$order_by = 'csde_soldpurvalue';
      	else if($this->input->get('iSortCol_0')==11)
      	 	$order_by = 'csde_sreturnqty';
      	else if($this->input->get('iSortCol_0')==12)
      	 	$order_by = 'csde_sreturnvalue';
      	else if($this->input->get('iSortCol_0')==13)
      	 	$order_by = 'csde_sreturnpvalue';
        else if($this->input->get('iSortCol_0')==14)
            $order_by = 'csde_stockqty';
        else if($this->input->get('iSortCol_0')==15)
       		$order_by = 'csde_stockvalue';
       	else if($this->input->get('iSortCol_0')==16)
      	 	$order_by = 'csde_issueqty';
      	else if($this->input->get('iSortCol_0')==17)
      	 	$order_by = 'csde_issueamount';
      	else if($this->input->get('iSortCol_0')==18)
      	 	$order_by = 'csde_receivedqty';
      	else if($this->input->get('iSortCol_0')==19)
      	 	$order_by = 'csde_receivedamnt';
        else if($this->input->get('iSortCol_0')==20)
            $order_by = 'csde_openingqty';
        else if($this->input->get('iSortCol_0')==21)
            $order_by = 'csde_openingamt';
        else if($this->input->get('iSortCol_0')==22)
       		$order_by = 'csde_curopeningqty';
       	else if($this->input->get('iSortCol_0')==23)
      	 	$order_by = 'csde_curopeningamt';
      	else if($this->input->get('iSortCol_0')==24)
      	 	$order_by = 'csde_transactionqty';
      	else if($this->input->get('iSortCol_0')==25)
      	 	$order_by = 'csde_transactionvalue';
      	else if($this->input->get('iSortCol_0')==26)
      	 	$order_by = 'csde_adjqty';
        else if($this->input->get('iSortCol_0')==27)
            $order_by = 'csde_adjvalue';
        else if($this->input->get('iSortCol_0')==28)
            $order_by = 'csde_mtdqty';
        else if($this->input->get('iSortCol_0')==29)
       		$order_by = 'csde_conqty';
       	else if($this->input->get('iSortCol_0')==30)
      	 	$order_by = 'csde_convalue';
      	else if($this->input->get('iSortCol_0')==31)
      	 	$order_by = 'csde_incconqty';
      	else if($this->input->get('iSortCol_0')==32)
      	 	$order_by = 'csde_returnqty';
      	
        else if($this->input->get('iSortCol_0')==33)
            $order_by = 'csde_incconvalue';
        else if($this->input->get('iSortCol_0')==34)
       		$order_by = 'csde_mtdvalue';
       	else if($this->input->get('iSortCol_0')==35)
       		$order_by = 'csde_challanqty';
        
      	$totalrecs='';
      	$limit = 15;
      	$offset = 1;
      	$get = $_GET;
 
	    foreach ($get as $key => $value) {
	        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
	    }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_3']."%' OR itli_itemnamenp like  '%".$get['sSearch_3']."%'  ");
        }
        // if(!empty($get['sSearch_4'])){
        //     $this->db->where("unit_unitname like  '%".$get['sSearch_4']."%'  ");
        // }
        // if(!empty($get['sSearch_5'])){
        //     $this->db->where("unit_unitname like  '%".$get['sSearch_5']."%'  ");
        // }
        // if(!empty($get['sSearch_6'])){
        //     $this->db->where("purd_qty like  '%".$get['sSearch_6']."%'  ");
        // }
        // if(!empty($get['sSearch_7'])){
        //     $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_7']."%'  ");
        // }
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
         $masterid = !empty($get['masterid'])?$get['masterid']:$this->input->post('masterid');

        if(!empty($masterid))
        {
            
            $this->db->where('cm.clsm_csmasterid',$masterid);
        }
        // $this->db->select('cd.*,cm.*,il.itli_itemcode,il.itli_itemname, u.unit_unitname, c.eqty_equipmenttype,SUM(csde_returnqty) as  prtnQty       ,SUM(csde_preturnvalue) as  prtnValue,SUM(csde_issueqty) as  issueQtyTtotal       ,SUM(csde_issueamount) as isAmnt,SUM(csde_openingqty) as  opQty     ,SUM(csde_openingamt) as opAmnt        ,SUM(csde_curopeningqty) as cuRQtyTotal       ,SUM(csde_curopeningamt) as curopeningamt       ,SUM(csde_transactionqty) as transactionqty        ,SUM(csde_transactionvalue) as transactionvalue        ,SUM(csde_adjqty) as  adjqty      ,SUM(csde_adjvalue) as  adjvalue ,SUM(csde_conqty) as outcon        ,SUM(csde_convalue) as outconvalue        ,SUM(csde_incconqty) as incconqty        ,SUM(csde_incconvalue) as incconvalue');
   if($this->location_ismain=='Y'){
     if(!empty($locationid)){
	  $this->db->where('csde_locationid',$locationid);
        }
        }else{
        	$this->db->where('csde_locationid',$this->locationid);

        }
        $this->db->select('cd.*,cm.*,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp, u.unit_unitname, c.eqty_equipmenttype');
        $this->db->from('csde_closingstockdetail cd');
        $this->db->join('clsm_closingstockmaster cm', 'cm.clsm_csmasterid = cd.csde_csmamasterid', "LEFT");
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = cd.csde_itemsid', "LEFT");
        $this->db->join('unit_unit u', 'u.unit_unitid = il.itli_unitid', "LEFT");
        $this->db->join('eqty_equipmenttype c', 'c.eqty_equipmenttypeid = il.itli_typeid', "LEFT");
        $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
      
        $nquery=$this->db->get();

        // echo $this->db->last_query();
        // die();
        $num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
        }

       if($num_row>0){
          $ndata=$nquery->result();
          $ndata['totalrecs'] = $totalrecs;
          $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } 
        else
        {
            $ndata=array();
            $ndata['totalrecs'] = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
	    //echo $this->db->last_query();die();
	   return $ndata;
	}

	public function get_closing_data_pdf($cond=false,$masterid=false)
	{
		$this->db->select('cd.*,cm.*,cd.*,il.itli_itemcode,il.itli_itemname, u.unit_unitname, c.eqty_equipmenttype,SUM(csde_returnqty) as  prtnQty       ,SUM(csde_preturnvalue) as  prtnValue,SUM(csde_issueqty) as  issueQtyTtotal       ,SUM(csde_issueamount) as isAmnt,SUM(csde_openingqty) as  opQty     ,SUM(csde_openingamt) as opAmnt        ,SUM(csde_curopeningqty) as cuRQtyTotal       ,SUM(csde_curopeningamt) as curopeningamt       ,SUM(csde_transactionqty) as transactionqty        ,SUM(csde_transactionvalue) as transactionvalue        ,SUM(csde_adjqty) as  adjqty      ,SUM(csde_adjvalue) as  adjvalue ,SUM(csde_conqty) as outcon        ,SUM(csde_convalue) as outconvalue        ,SUM(csde_incconqty) as incconqty        ,SUM(csde_incconvalue) as incconvalue');
        $this->db->from('csde_closingstockdetail cd');
        $this->db->join('clsm_closingstockmaster cm', 'cm.clsm_csmasterid = cd.csde_csmamasterid', "LEFT");
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = cd.csde_itemsid', "LEFT");
        $this->db->join('unit_unit u', 'u.unit_unitid = il.itli_unitid', "LEFT");
        $this->db->join('eqty_equipmenttype c', 'c.eqty_equipmenttypeid = il.itli_typeid', "LEFT");
        
        $masterid = !empty($this->input->get('masterid'))?$this->input->get('masterid'):$this->input->post('masterid');
        //echo $masterid; die;

        if($cond)
        {
            $this->db->where($cond);
        }
        if(!empty($masterid))
        {
            
            $this->db->where('cm.clsm_csmasterid',$masterid);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();    
            return $data;           
        }
        return false;
	}
}
	