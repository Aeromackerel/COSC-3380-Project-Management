DECLARE @responseMessage NVARCHAR(150)

-- Correct Login information
EXEC dbo.usLogin
	@pEmail = N'Admin',
	@pPassword = N'123',
	@responseMessage = @responseMessage OUTPUT

SELECT @responseMessage as N'@responseMessage'

-- Incorrect Login information
EXEC dbo.usLogin
	@pEmail = N'Admin1',
	@pPassword = N'123',
	@responseMessage = @responseMessage OUTPUT

SELECT @responseMessage as N'@responseMessage'

-- Incorrect PW
EXEC dbo.usLogin
	@pEmail = N'Admin',
	@pPassword = N'12',
	@responseMessage = @responseMessage OUTPUT

SELECT @responseMessage as N'@responseMessage'