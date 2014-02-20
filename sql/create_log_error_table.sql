-- ---------------------------
--
-- Create logerror table
--
-- 20/02/2014 CDN					Create
--
--
-- ---------------------------
DROP TABLE IF EXISTS logerror;
CREATE TABLE IF NOT EXISTS logerror
(
	id INT AUTO_INCREMENT,
	created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	lastupdated TIMESTAMP NOT NULL DEFAULT NOW(),

	message TEXT NOT NULL,
	code INT NOT NULL,
	filename VARCHAR(250) NOT NULL,
	line  INT NOT NULL,
	trace TEXT,
	exceptionstring TEXT,

	PRIMARY KEY(id)

) ENGINE=MyIsam;