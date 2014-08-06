SELECT item,
       job,
       subinventory_code location,
       --locator_id,
       date_received,
       lpn,
       aged_days,
       onhand_qty,
       CASE
           WHEN lpn IS NULL THEN 'UNPACKED'
           ELSE 'PACKED'
       END pack_status,
       CASE
           WHEN subinventory_code NOT LIKE 'MSPR%' THEN 'INCORRECT LOCATION'
           ELSE 'TRANSFERRED'
       END status
FROM apps.xxbi_cyp_onhand_inv_v@osfm
WHERE organization_code = 'F07'
  AND job IN (':serial_num')