CREATE TRIGGER TR_eventDelete
ON Events
AFTER DELETE
AS
BEGIN
	PRINT 'Someone has deleted an event - please take a look at the events listing.'
END
GO