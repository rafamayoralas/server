/* Plays |  Unique Plays |  Minutes viewed |  player impressions  |  Avg. View time |  Impression to play ratio */
SELECT
	SUM(count_plays) count_plays,
#	AVG(distinct_plays) distinct_plays, /* Because we don't know the real number, we use avarage instead*/
	SUM(sum_time_viewed) sum_time_viewed,
	SUM(sum_time_viewed)/SUM(count_plays) avg_time_viewed,
	SUM(count_loads) count_loads,
	( SUM(count_plays) / SUM(count_loads) ) load_play_ratio
FROM 
	dwh_hourly_partner ev

WHERE 
	ev.partner_id =  {PARTNER_ID} # PARTNER_ID
    AND date_id BETWEEN IF({TIME_SHIFT}>0,(DATE({FROM_DATE_ID}) - INTERVAL 1 DAY)*1, {FROM_DATE_ID})  
   			AND     IF({TIME_SHIFT}<=0,(DATE({TO_DATE_ID}) + INTERVAL 1 DAY)*1, {TO_DATE_ID})
		AND hour_id >= IF (date_id = IF({TIME_SHIFT}>0,(DATE({FROM_DATE_ID}) - INTERVAL 1 DAY)*1, {FROM_DATE_ID}), IF({TIME_SHIFT}>0, 24 - {TIME_SHIFT}, ABS({TIME_SHIFT})), 0)
		AND hour_id < IF (date_id = IF({TIME_SHIFT}<=0,(DATE({TO_DATE_ID}) + INTERVAL 1 DAY)*1, {TO_DATE_ID}), IF({TIME_SHIFT}>0, 24 - {TIME_SHIFT}, ABS({TIME_SHIFT})), 24)
	AND 
		( count_time_viewed > 0 OR
		  count_plays > 0 OR
		  count_loads > 0 OR 
		  sum_time_viewed > 0 )