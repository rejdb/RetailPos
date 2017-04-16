use `pos_production`;

DROP VIEW IF EXISTS `view_branches`;
CREATE VIEW view_branches AS
SELECT t0.*
, t1.Category as 'CategoryDesc'
, t2.Channel as 'ChannelDesc'
, t3.City as 'CityDesc'
, t4.Description as 'GroupDesc'
, t5.TypeDesc
, t6.Start
, t6.Current
, t6.End
, (SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = t0.Manager) as 'AreaManager'
FROM md_branches t0
LEFT JOIN ref_branch_category t1 ON t0.Category = t1.CatID
LEFT JOIN ref_branch_channel t2 ON t0.Channel = t2.ChannelID
LEFT JOIN ref_branch_city t3 ON t0.City = t3.CityID
LEFT JOIN ref_branch_group t4 ON t0.Groups = t4.GroupID
LEFT JOIN ref_branch_type t5 ON t0.Type = t5.TypeID
LEFT JOIN ref_branch_series t6 ON t0.BranchID = t6.Branch;

CREATE VIEW view_campaign AS
SELECT t0.*,
t1.BranchID,
t3.Description as 'BranchName',
t2.PID,
t4.ProductDesc,
t2.SRP
FROM md_campaign t0
LEFT JOIN stp_campaign_branch t1 ON t0.CampaignID = t1.CampaignID
LEFT JOIN stp_campaign_item t2 ON t0.CampaignID = t2.CampaignID
LEFT JOIN md_branches t3 ON t1.BranchID = t3.BranchID
LEFT JOIN md_items t4 ON t2.PID = t4.PID;

CREATE VIEW view_customer AS
SELECT t0.*
, t1.BranchCode
, t1.Description as BranchDesc
, t1.CategoryDesc
, t1.ChannelDesc
, t1.CityDesc
, t1.GroupDesc
, t1.TypeDesc
, t2.City as Cust_City
, t3.Province as Cust_Provice
FROM md_customer t0
LEFT JOIN view_branches t1 ON t0.Branch = t1.BranchID
LEFT JOIN ref_branch_city t2 ON t0.CustCity = t2.CityID
LEFT JOIN ref_province t3 ON t0.CustProvince = t3.ProvinceID;

CREATE VIEW view_frontliners AS
select t0.*
, t1.UsrTargetID
, t1.Target
, t2.BranchID
, t2.UserBranchID
, t3.Description
from md_user t0 
INNER JOIN ref_user_target t1 on t0.UID = t1.UserID
LEFT JOIN ref_user_branch t2 on t0.UID = t2.UserID
LEFT JOIN md_branches t3 on t2.BranchID = t3.BranchID;

CREATE VIEW view_items AS
SELECT t0.* 
,t1.Description as 'BrandDesc'
,t2.Description as 'CategoryDesc'
,t3.Description as 'CycleDesc'
,t4.Description as 'PriceListDesc'
,t7.Description as FamilyDesc
,t8.Description as TypeDesc
,t5.PDID
,IFNULL(t5.Price,0) as 'CurrentPrice'
,IFNULL((SELECT SUM(I0.Available) FROM md_inventory I0 WHERE I0.Product=t0.PID),0) as 'Inventory'
FROM md_items t0
LEFT JOIN ref_item_brand t1 ON t0.Brand = t1.BrandID
LEFT JOIN ref_item_category t2 ON t0.Category = t2.P_CatID
LEFT JOIN ref_item_cycle t3 ON t0.LifeCycle = t3.P_CycleID
LEFT JOIN ref_item_family t7 ON t0.Family = t7.FamID
LEFT JOIN ref_item_type t8 ON t0.ItemType = t8.TypeID
LEFT JOIN stp_item_pricelist t4 ON t0.PriceList = t4.PLID
LEFT JOIN stp_item_pricedetails t5 ON (t0.PID = t5.PID AND t0.PriceList = t5.PLID);

CREATE VIEW view_inventory AS
SELECT t0.*
,t1.*
,t2.BarCode
,t2.ProductDesc
,t2.SKU
,t2.Brand
,t2.Category as 'ItemCategory'
,t2.LifeCycle
,t2.IsSerialized
,t2.OrderLevel
,t2.StdCost
,t2.PriceList
,t2.PriceListDesc
,t2.IsActive as 'IsItemActive'
,t2.TypeDesc as ItemTypeDesc
,t2.BrandDesc
,t2.CategoryDesc as 'ItemCategoryDesc'
,t2.CycleDesc
,t2.FamilyDesc
,t2.PDID
,t2.CurrentPrice
,t3.WhsName
,(t2.StdCost*(1+(t1.SalesTax/100))) as 'CostVatInc'
,(t2.CurrentPrice*(1+(t1.SalesTax/100))) as 'PriceVatInc'
,t0.InStocks*(t2.StdCost*(1+(t1.SalesTax/100))) as 'TotalCostVatInc'
,t0.InStocks*(t2.CurrentPrice*(1+(t1.SalesTax/100))) as 'TotalPriceVatInc'

FROM md_inventory t0 
INNER JOIN view_branches t1 ON t0.Branch = t1.BranchID
INNER JOIN view_items t2 ON t0.Product = t2.PID
INNER JOIN md_warehouses t3 ON t0.Warehouse = t3.WhsCode;

CREATE VIEW view_inventory_serials AS
select `t0`.`InvSerID` AS `InvSerID`
,`t0`.`Product` AS `Product`
,`t0`.`Warehouse` AS `Warehouse`
,`t0`.`Branch` AS `Branch`
,`t0`.`IsSold` AS `IsSold`
,`t0`.`Serial` AS `Serial`
,`t0`.`InDate` AS `InDate`
,`t1`.`BranchID` AS `BranchID`
,`t1`.`BranchCode` AS `BranchCode`
,`t1`.`Description` AS `Description`
,`t1`.`BranchEmail` AS `BranchEmail`
,`t1`.`Type` AS `Type`
,`t1`.`Category` AS `Category`
,`t1`.`Groups` AS `Groups`
,`t1`.`Channel` AS `Channel`
,`t1`.`City` AS `City`
,`t1`.`Address` AS `Address`
,`t1`.`Manager` AS `Manager`
,`t1`.`IsTaxInclude` AS `IsTaxInclude`
,`t1`.`SalesTax` AS `SalesTax`
,`t1`.`DefaultReturnPolicy` AS `DefaultReturnPolicy`
,`t1`.`IsBackdateAllowed` AS `IsBackdateAllowed`
,`t1`.`IsActive` AS `IsActive`
,`t1`.`Avatar` AS `Avatar`
,`t1`.`CreateDate` AS `CreateDate`
,`t1`.`UpdateDate` AS `UpdateDate`
,`t1`.`CategoryDesc` AS `CategoryDesc`
,`t1`.`ChannelDesc` AS `ChannelDesc`
,`t1`.`CityDesc` AS `CityDesc`
,`t1`.`GroupDesc` AS `GroupDesc`
,`t1`.`TypeDesc` AS `TypeDesc`
,`t2`.`BarCode` AS `BarCode`
,`t2`.`ProductDesc` AS `ProductDesc`
,`t2`.`SKU` AS `SKU`
,`t2`.`ItemType`
,`t2`.`Brand` AS `Brand`
,`t2`.`Category` AS `ItemCategory`
,`t2`.`LifeCycle` AS `LifeCycle`
,`t2`.`Family` AS `Family`
,`t2`.`IsSerialized` AS `IsSerialized`
,`t2`.`OrderLevel` AS `OrderLevel`
,`t2`.`StdCost` AS `StdCost`
,`t2`.`PriceList` AS `PriceList`
,`t2`.`PriceListDesc` AS `PriceListDesc`
,`t2`.`IsActive` AS `IsItemActive`
,`t2`.`TypeDesc` AS `ItemTypeDesc`
,`t2`.`BrandDesc` AS `BrandDesc`
,`t2`.`CategoryDesc` AS `ItemCategoryDesc`
,`t2`.`CycleDesc` AS `CycleDesc`
,`t2`.`FamilyDesc` AS `FamilyDesc`
,`t2`.`PDID` AS `PDID`
,`t2`.`CurrentPrice` AS `CurrentPrice`
,`t3`.`WhsName` AS `WhsName` 

from `md_inventory_serials` `t0` 
inner join `view_branches` `t1` on `t0`.`Branch` = `t1`.`BranchID`
inner join `view_items` `t2` on `t0`.`Product` = `t2`.`PID`
inner join `md_warehouses` `t3` on `t0`.`Warehouse` = `t3`.`WhsCode`;

CREATE VIEW view_pullout AS
SELECT T0.*
,T1.BranchCode
,T1.Description
,T1.BranchEmail
,T1.Address
,T1.CategoryDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.IsTaxInclude
,T1.Avatar
,T2.DisplayName
,(SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = T0.Approver) as 'ApprovedBy'
,(SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = T0.Confirmed) as 'ConfirmedBy'
FROM trx_pullout T0 
INNER JOIN view_branches T1 ON T0.Branch = T1.BranchID
INNER JOIN md_user T2 ON T0.CreatedBy = T2.UID;

CREATE VIEW view_pullout_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.IsSerialized
, T2.WhsName
FROM trx_pullout_row T0
INNER JOIN md_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

CREATE VIEW view_purchase AS
SELECT T0.*
,T1.BranchCode
,T1.Description
,T1.BranchEmail
,T1.Address
,T1.CategoryDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.IsTaxInclude
,T1.Avatar
,T2.CoyName
,T2.ContactPerson
,T2.Email AS 'SupplierEmail'
,T2.BillTo
,T3.DisplayName
FROM trx_purchase T0 
INNER JOIN view_branches T1 ON T0.ShipToBranch = T1.BranchID
INNER JOIN md_supplier T2 ON T0.Supplier = T2.SuppID
INNER JOIN md_user T3 ON T0.CreatedBy = T3.UID;

CREATE VIEW view_purchase_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.IsSerialized
, T2.WhsName
FROM trx_purchase_row T0
INNER JOIN md_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

CREATE VIEW view_receiving AS
SELECT T0.*
,T1.BranchCode
,T1.Description
,T1.BranchEmail
,T1.Address
,T1.CategoryDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.IsTaxInclude
,T1.Avatar
,T2.DisplayName
FROM trx_receiving T0 
INNER JOIN view_branches T1 ON T0.Branch = T1.BranchID
INNER JOIN md_user T2 ON T0.CreatedBy = T2.UID;

CREATE VIEW view_receiving_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.IsSerialized
, T2.WhsName
FROM trx_receiving_row T0
INNER JOIN md_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

CREATE VIEW view_return AS
SELECT T0.*
,T1.BranchCode
,T1.Description
,T1.CategoryDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.Address
,T2.DisplayName
FROM trx_return T0 
INNER JOIN view_branches T1 ON T0.Branch = T1.BranchID
INNER JOIN md_user T2 ON T0.CreatedBy = T2.UID;

CREATE VIEW view_return_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.TypeDesc
, T1.BrandDesc
, T1.CategoryDesc
, T1.CycleDesc
, T1.FamilyDesc
, T1.IsSerialized
, T2.WhsName
FROM trx_return_row T0
INNER JOIN view_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

CREATE VIEW view_sales AS
SELECT T0.*
,T1.BranchCode
,T1.Description
,T1.CategoryDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.Address
,T2.DisplayName
FROM trx_sales T0 
INNER JOIN view_branches T1 ON T0.Branch = T1.BranchID
INNER JOIN md_user T2 ON T0.CreatedBy = T2.UID;

CREATE VIEW view_sales_customer AS
SELECT T0.*
, T1.CustPoints
, T1.CustCredits
FROM trx_sales_customer T0
LEFT JOIN md_customer T1 ON T0.CardNo = T1.CardNo;

CREATE VIEW view_sales_payments AS
SELECT T0.*
, (Select I0.RefNo From trx_sales I0 Where I0.TransID = T0.TransID) as InvoiceRef
,`T1`.`PaymentName` AS `PaymentName`
, (Select I0.BankName FROM ref_terminal I0 Where I0.BankID = T0.Terminal) as BankName
, (Select I0.BankName FROM ref_terminal I0 Where I0.BankID = T0.IssuingBank) as IssuingBankName
,`T3`.`InstDesc` AS `InstDesc` 
,`T4`.BranchCode
,`T4`.Description AS BranchDesc
FROM trx_sales_payments T0
INNER JOIN view_branches T4 ON T0.Branch = T4.BranchID
INNER JOIN ref_payment_type T1 ON T0.PaymentType = T1.PaymentId
LEFT JOIN ref_installment T3 ON T0.Installment = T3.InsId;

CREATE VIEW view_sales_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.TypeDesc
, T1.BrandDesc
, T1.CategoryDesc
, T1.CycleDesc
, T1.FamilyDesc
, T1.IsSerialized
, T2.WhsName
FROM trx_sales_row T0
INNER JOIN view_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

CREATE VIEW view_smr AS
SELECT T0.*
,T1.BranchCode
,T1.Description as BranchDesc
,T1.CategoryDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.TypeDesc
,T1.GroupDesc
,T2.BarCode
,T2.ProductDesc
,T2.SKU
,T2.BrandDesc
,T2.CategoryDesc as ItemCategory
,T2.CycleDesc
,T2.FamilyDesc
,T2.TypeDesc as ItemTypeDesc
,T2.StdCost
,T2.CurrentPrice
,T3.WhsName
FROM trx_stocks_movement T0
INNER JOIN view_branches T1 ON T0.Branch=T1.BranchID
INNER JOIN view_items T2 ON T0.Product=T2.PID
INNER JOIN md_warehouses T3 ON T0.Warehouse=T3.WhsCode;

CREATE VIEW view_transfer AS
SELECT T0.*
,IF(T0.TransferType=0,(SELECT I0.Description FROM md_branches I0 WHERE I0.BranchID=T0.InvFrom),(SELECT I0.WhsName FROM md_warehouses I0 WHERE I0.WhsCode=T0.InvFrom)) as TransferFrom
,IF(T0.TransferType=0,(SELECT I0.Description FROM md_branches I0 WHERE I0.BranchID=T0.InvTo),(SELECT I0.WhsName FROM md_warehouses I0 WHERE I0.WhsCode=T0.InvTo)) as TransferTo
,IF(T0.TransferType=0,'Store Transfer','Warehouse Transfer') as TransType
,T1.BranchCode
,T1.Description
,T1.BranchEmail
,T1.Address
,T1.CategoryDesc
,T1.GroupDesc
,T1.TypeDesc
,T1.ChannelDesc
,T1.CityDesc
,T1.IsTaxInclude
,T1.Avatar
,T2.DisplayName
,(SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = T0.Approver) as 'ApprovedBy'
,(SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = T0.Receiver) as 'ReceivedBy'
FROM trx_transfer T0 
INNER JOIN view_branches T1 ON T0.Branch = T1.BranchID
INNER JOIN md_user T2 ON T0.CreatedBy = T2.UID;

CREATE VIEW view_transfer_row AS
SELECT T0.*
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.IsSerialized
, T2.WhsName
FROM trx_transfer_row T0
INNER JOIN md_items T1 ON T0.ProductID = T1.PID
INNER JOIN md_warehouses T2 ON T0.Warehouse = T2.WhsCode;

CREATE VIEW view_sales_postpaid AS
SELECT t0.* 
, t1.BranchCode
, t1.Description as BranchDesc
, t1.CategoryDesc
, t1.ChannelDesc
, t1.CityDesc
, t1.GroupDesc
, t1.TypeDesc
, IF(t0.Status=0,"For Activation",IF(t0.Status=1,"Activated","Cancelled")) as StatusDesc
, (SELECT I0.DisplayName FROM md_user I0 WHERE I0.UID = t0.CreatedBy) as SoldBy
FROM trx_sales_postpaid t0
INNER JOIN view_branches t1 ON t0.Branch = t1.BranchID;

CREATE VIEW report_cash_register AS
SELECT T0.TransDate
, T0.Branch
, T0.BranchCode
, T0.BranchDesc
, T0.IsDeposited
, T0.DepositSlip
, T0.PaymentType
, T0.PaymentName
, SUM(T0.Amount) as 'Amount'
FROM view_sales_payments T0
GROUP BY T0.TransDate
, T0.Branch
, T0.BranchCode
, T0.BranchDesc
, T0.IsDeposited
, T0.DepositSlip
, T0.PaymentType
, T0.PaymentName
HAVING (SUM(T0.Amount)!=0);

CREATE VIEW report_return AS
SELECT T0.TransID
, T0.RefNo
, WEEK(T0.TransDate) as 'Week'
, YEAR(T0.TransDate) as 'Year'
, MONTH(T0.TransDate) as 'Month'
, DAY(T0.TransDate) as 'Day'
, T0.TransDate
, T0.Branch
, T0.BranchCode
, T0.Description as 'BranchDesc'
, T0.CategoryDesc
, T0.ChannelDesc
, T0.CityDesc
, T0.GroupDesc
, T0.TypeDesc
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.TypeDesc as ItemTypeDesc
, T1.BrandDesc
, T1.CategoryDesc as ItemCategory
, T1.CycleDesc
, T1.FamilyDesc
, T1.WhsName
, T1.Quantity
, T1.Cost
, T1.Price
, T1.Subsidy
, T1.PriceAfSub
, T1.OutputTax
, T1.TaxAmount
, T1.PriceAfVat
, T1.Discount
, T1.DiscValue
, T1.Total
, T1.TotalAfSub
, T1.TotalAfVat
, T1.GTotal as TotalAfDiscount
, T1.Serial
, T1.Campaign
, T2.FullName as CustomerName
, T2.ContactNo as CustomerContactNo
, T2.Email as CustomerEmail
, T2.Address as CustomerAddress
, T0.DisplayName as 'FrontLiner'
, T0.NetTotal
, IFNULL((SELECT SUM(I0.Amount) FROM view_sales_payments I0 WHERE I0.TransID = T0.TransID and I0.PaymentType = 1),0) as CashPayment
, IFNULL((SELECT SUM(I0.Amount) FROM view_sales_payments I0 WHERE I0.TransID = T0.TransID and I0.PaymentType != 1),0) as CardPayment
FROM view_return T0
INNER JOIN view_return_row T1 ON T0.TransID = T1.TransID
INNER JOIN view_sales_customer T2 ON T0.TransID = T2.TransID;

CREATE VIEW report_sales AS
SELECT T0.TransID
, T0.RefNo
, WEEK(T0.TransDate) as 'Week'
, YEAR(T0.TransDate) as 'Year'
, MONTH(T0.TransDate) as 'Month'
, DAY(T0.TransDate) as 'Day'
, T0.TransDate
, T0.Branch
, T0.BranchCode
, T0.Description as 'BranchDesc'
, T0.CategoryDesc
, T0.ChannelDesc
, T0.CityDesc
, T0.GroupDesc
, T0.TypeDesc
, T1.BarCode
, T1.ProductDesc
, T1.SKU
, T1.TypeDesc as ItemTypeDesc
, T1.BrandDesc
, T1.CategoryDesc as ItemCategory
, T1.CycleDesc
, T1.FamilyDesc
, T1.WhsName
, T1.Quantity
, T1.Cost
, T1.Price
, T1.Subsidy
, T1.PriceAfSub
, T1.OutputTax
, T1.TaxAmount
, T1.PriceAfVat
, T1.Discount
, T1.DiscValue
, T1.Total
, T1.TotalAfSub
, T1.TotalAfVat
, T1.GTotal as TotalAfDiscount
, T1.Serial
, T1.Campaign
, T2.FullName as CustomerName
, T2.ContactNo as CustomerContactNo
, T2.Email as CustomerEmail
, T2.Address as CustomerAddress
, T0.DisplayName as 'Cashier'
, T0.NetTotal
, IFNULL((SELECT SUM(I0.Amount) FROM view_sales_payments I0 WHERE I0.TransID = T0.TransID and I0.PaymentType = 1),0) as CashPayment
, IFNULL((SELECT SUM(I0.Amount) FROM view_sales_payments I0 WHERE I0.TransID = T0.TransID and I0.PaymentType != 1),0) as CardPayment
FROM view_sales T0
INNER JOIN view_sales_row T1 ON T0.TransID = T1.TransID
INNER JOIN view_sales_customer T2 ON T0.TransID = T2.TransID;

CREATE VIEW report_sales_detailed AS
SELECT *,
IF(a.PriceAfVat < 1000, "<1000",
IF(a.PriceAfVat>1000 and a.PriceAfVat<=2499, "1,000 - 2,499",
IF(a.PriceAfVat>2499 and a.PriceAfVat<=4999, "2,499 - 4,999",
IF(a.PriceAfVat>4999 and a.PriceAfVat<=7499, "5,000 - 7,499",
IF(a.PriceAfVat>7499 and a.PriceAfVat<=9999, "7,500 - 9,999",
IF(a.PriceAfVat>9999 and a.PriceAfVat<=14999, "10,000 - 14,999",
IF(a.PriceAfVat>14999 and a.PriceAfVat<=19999, "15,000 - 19,999",
IF(a.PriceAfVat>19999 and a.PriceAfVat<=24999, "20,000 - 24,999",
"25,000 and Above")))))))) as PriceBand
, (a.TotalAfDiscount * (a.CashPayment/a.NetTotal)) as Cash_Payment
, (a.TotalAfDiscount * (a.CardPayment/a.NetTotal)) as NonCash_Payment
FROM (SELECT *,'invoice' as Module FROM `report_sales` UNION ALL
SELECT *,'return' FROM `report_return`) AS a;

CREATE VIEW report_sales_summary AS
SELECT * 
FROM (SELECT *,'invoice' as Module FROM `view_sales` UNION ALL
SELECT *,'return' FROM `view_return`) AS a;

CREATE PROCEDURE Report_SRM(IN `DateFrom` DATE, IN `DateTo` DATE)
(SELECT a.Branch, a.Product, a.Warehouse, a.BranchCode, a.BranchDesc, a.CategoryDesc, a.ChannelDesc
, a.CityDesc, a.TypeDesc, a.GroupDesc, a.BarCode, a.ProductDesc, a.SKU
, a.BrandDesc, a.ItemCategory, a.CycleDesc, a.FamilyDesc, a.ItemTypeDesc, a.WhsName
, SUM(a.Beginning) as 'Beginning', SUM(a.GRPO) as 'GRPO'
, SUM(a.Receiving) as 'Receiving', SUM(a.TransferIn) as 'TransferIn'
, SUM(a.TransferOut) as 'TransferOut', SUM(a.Sales) as 'Sales', SUM(a.Postpaid) as 'Postpaid'
, SUM(a.SalesReturn) as 'SalesReturn', SUM(a.PullOut) as 'PullOut', SUM(a.Ending) as 'Ending'
FROM (
SELECT t0.Branch, t0.Product, t0.Warehouse, t0.BranchCode, t0.BranchDesc, t0.CategoryDesc
, t0.ChannelDesc, t0.CityDesc, t0.TypeDesc, t0.GroupDesc, t0.BarCode, t0.ProductDesc, t0.SKU
, t0.BrandDesc, t0.ItemCategory, t0.CycleDesc, t0.FamilyDesc, t0.ItemTypeDesc, t0.WhsName
, SumInOut as 'Beginning', 0 as 'GRPO', 0 as 'Sales', 0 as 'Postpaid', 0 as 'SalesReturn'
, 0 as 'Receiving', 0 as 'TransferIn', 0 as 'TransferOut', 0 as 'PullOut', SumInOut as 'Ending'
FROM view_smr t0 WHERE t0.Date < DateFrom
UNION ALL
SELECT t0.Branch, t0.Product, t0.Warehouse, t0.BranchCode, t0.BranchDesc, t0.CategoryDesc
, t0.ChannelDesc, t0.CityDesc, t0.TypeDesc, t0.GroupDesc, t0.BarCode, t0.ProductDesc, t0.SKU
, t0.BrandDesc, t0.ItemCategory, t0.CycleDesc, t0.FamilyDesc, t0.ItemTypeDesc, t0.WhsName
, 0 as 'Beginning'
, IF(t0.Module='/purchase',SumInOut,0) as 'GRPO'
, IF(t0.Module='/sales' and t0.TransType='/invoice',SumInOut,0) as 'Sales'
, IF(t0.Module='/sales' and t0.TransType='/postpaid',SumInOut,0) as 'Postpaid'
, IF(t0.Module='/sales' and t0.TransType='/return',SumInOut,0) as 'Returns'
, IF(t0.Module='/stocks' and t0.TransType='/receiving',SumInOut,0) as 'Receiving'
, IF(t0.Module='/stocks' and t0.TransType='/transfer',MoveIn,0) as 'TransferIn'
, IF(t0.Module='/stocks' and t0.TransType='/transfer',MoveOut*-1,0) as 'TransferOut'
, IF(t0.Module='/stocks' and t0.TransType='/pullout',SumInOut,0) as 'PullOut'
, SumInOut as 'Ending'
FROM view_smr t0 WHERE t0.Date BETWEEN DateFrom and DateTo) as a
GROUP BY a.Branch
, a.Product, a.Warehouse, a.BranchCode, a.BranchDesc, a.CategoryDesc, a.ChannelDesc
, a.CityDesc, a.TypeDesc, a.GroupDesc, a.BarCode, a.ProductDesc, a.SKU
, a.BrandDesc, a.ItemCategory, a.CycleDesc, a.FamilyDesc, a.ItemTypeDesc, a.WhsName);

