## Situation

1. View with form is generated in EventController.php on line 15. Symfony loads EventReport entity, and through EventReportDataTransferer transforms the entity into EventReportDto.
2. EventReport has One-to-Many relation with EventUser entity, so one EventReport can have 0..n EventUsers, with EventUser being the owning side.
3. EventUser selection in form is interfaced using EntityType with multiple options.
4. On valid form submit the EventReportDto is transformed back to EventReport entity, which is then persisted to database.

## Expected behaviour

1. I'm editing the existing EventReport entity, which contains single EventUser.

![EventUsers in different stages](https://github.com/machacjan/dto/blob/master/screen.png)
