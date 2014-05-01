select * from sermonstalks;
update sermonstalks set lastupdated = now() where id <= 10;
select * from sermonstalks order by lastupdated DESC;
update sermonstalks set dateperformed = now() where id <= 10;