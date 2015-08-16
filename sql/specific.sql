-- Query Detailed WIP
select 
item, 
job, 
To_Char(job_creation_date,'dd-Mon-yyyy hh:mi pm') job_creation_date, 
opn_code, 
opn_description, 
(qty_in_queue+qty_running+Qty_waiting_to_move-qty_scrapped) qty, 
job_status, 
days_since_last_move, 
days_since_job_creation, 
To_Char(job_last_move_date,'dd-Mon-yyyy hh:mi pm')job_last_move_date
-- To_Char(job_estimated_completion_date,'dd-Mon-yyyy hh:mi pm')job_estimated_completion_date  
from dare_pkg.mv_wip30min_rpt@PROD_MX.MAT.AVAGOTECH.NET
where department_code = ':family'