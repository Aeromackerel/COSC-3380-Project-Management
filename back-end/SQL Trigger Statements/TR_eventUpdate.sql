CREATE TRIGGER TR_eventUpated
ON Events
AFTER UPDATE
AS
BEGIN
	PRINT 'Someone has updated an event''s time and location.'
END
GO