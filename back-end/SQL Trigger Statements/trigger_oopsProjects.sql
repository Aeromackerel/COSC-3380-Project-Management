CREATE TRIGGER [dbo].[trigger_oopsProjects]
ON Projects
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON
	IF UPDATE(statusID)
	BEGIN
	UPDATE Projects
		SET actualEndDate = NULL
		FROM Projects P INNER JOIN Inserted I
		ON P.projectId = I.projectId
		WHERE I.statusID < 5
	END
END