CREATE TRIGGER [dbo].[oopsTask]
	ON Tasks
	AFTER UPDATE
	AS
	BEGIN
		SET NOCOUNT ON
		IF UPDATE(status)
		BEGIN
		UPDATE Tasks
		SET actualEndDateTime = NULL
		FROM Tasks T INNER JOIN Inserted I
		ON T.taskId = I.taskId
		WHERE I.status = 1
		END
END
