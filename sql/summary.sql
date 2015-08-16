--Query Summary WIP

SELECT opn_code,
       opn_description,
       count(job) packs,
       sum((qty_in_queue+qty_running+qty_waiting_to_move-qty_scrapped)) qty,
       median(days_since_last_move) med_stalled_time,
       min(days_since_last_move) min_stalled_time,
       max(days_since_last_move) max_stalled_time,
       median(days_since_job_creation) med_cycle_time,
       min(days_since_job_creation) min_cycle_time,
       max(days_since_job_creation) max_cycle_time
FROM dare_pkg.mv_wip30min_rpt@PROD_MX.MAT.AVAGOTECH.NET
WHERE department_code = ':family'
  -- AND department_code = 'OSACRTDV'
  -- AND department_code = 'OSA-COC'
  -- AND department_code = 'OSA2-5GB'
  -- AND department_code = 'OSA10GB'
  -- AND department_code = 'OSA'
GROUP BY opn_code,
         opn_description,
         job_status