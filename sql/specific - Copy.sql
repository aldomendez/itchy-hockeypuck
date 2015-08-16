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
To_Char(job_last_move_date,'dd-Mon-yyyy hh:mi pm')job_last_move_date, 
To_Char(job_estimated_completion_date,'dd-Mon-yyyy hh:mi pm')job_estimated_completion_date  
from apps.xxbi_cyp_wip_job_inv_v@osfm
where organization_code ='F07'
and department_code = ':family'