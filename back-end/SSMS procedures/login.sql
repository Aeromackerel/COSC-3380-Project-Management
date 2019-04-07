CREATE PROCEDURE dbo.usLogin
	@pEmail NVARCHAR(40),
	@pPassword NVARCHAR(50),
	@responseMessage NVARCHAR(150) OUTPUT

AS
BEGIN

	SET NOCOUNT ON

	DECLARE @userID INT

	IF EXISTS (SELECT TOP 1 userID FROM [dbo].[Users] WHERE email = @pEmail)
	BEGIN
		SET @userID = (SELECT UserID From [dbo].[Users] WHERE email = @pEmail AND passwordHash=HASHBYTES('SHA2_512',@pPassword+CAST(Salt AS NVARCHAR(36))))

		IF (@userID IS NULL)
			SET @responseMessage='Incorrect Password entered'
		ELSE
			SET @responseMessage='You''ve been successfully logged in.'
		END
		ELSE
			SET @responseMessage='User not found'

END