SELECT * FROM bobiles_church_smarty.calendar order by eventdate, eventtime;
select count('id') as row_count from bobiles_church_smarty.calendar where isvisible = 'YES';
select * from bobiles_church_smarty.calendar where eventdate > '2014-03-07';
SELECT * FROM bobiles_church_smarty.calendar;
select * from forthcomingevents;
select * from regularevents;
select re.*, me.id as menuid from regularevents re, menus me where re.eventname = me.prompt;


