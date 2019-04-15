CREATE TRIGGER TR_checkProjectCosts ON ProjectCosts
FOR UPDATE, INSERT
AS
IF (UPDATE(totalBudget) OR UPDATE(totalCosts) OR UPDATE(maintainenceCosts))
BEGIN
DECLARE @totalBudget INT, @totalCosts INT, @maintainenceCosts INT
SET @totalBudget=(SELECT totalBudget FROM ProjectCosts)
SET @totalCosts=(SELECT totalCosts FROM ProjectCosts)
SET @maintainenceCosts=(SELECT maintainenceCosts FROM ProjectCosts)
IF (@totalBudget - (@totalCosts+@maintainenceCosts) < 10000)
BEGIN
PRINT ('Please check the ProjectCosts table for updates to project finances')
END
END