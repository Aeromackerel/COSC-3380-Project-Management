CREATE TRIGGER [dbo].[trigger_CompleteProjects]
ON Projects
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON
	IF UPDATE(statusID)
	BEGIN
	UPDATE Projects
	SET actualEndDate = CURRENT_TIMESTAMP
		FROM Projects P INNER JOIN Inserted I
		ON P.projectId = I.projectId
		WHERE I.statusID = 5
	END
END