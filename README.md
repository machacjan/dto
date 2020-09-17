## Situation

1. View with form is generated in EventController.php on line 15. Symfony loads EventReport entity, and through EventReportDataTransferer transforms the entity into EventReportDto.
2. EventReport has One-to-Many relation with EventUser entity, so one EventReport can have 0..n EventUsers, with EventUser being the owning side.
3. EventUser selection in form is interfaced using EntityType with multiple options.
4. On valid form submit the EventReportDto is transformed back to EventReport entity, which is then persisted to database.

## Expected behaviour

1. I'm editing the existing EventReport entity, which contains single EventUser.
2. I remove that single EventUser from the selected list.
3. I add two new EventUsers to the list, and submit the form.
4. In the process of transfering EventReportDto to EventReport entity, I compare the original EventUsers from before I started editing it with the new data sent by the form.
5. Since the original entity is queried from the database (see EventReportDataTransferer:53), there should be a difference, by which I should be able to determine which EventUsers were added, and which where removed.

## Actual behaviour

1. DTTO
2. DTTO
3. DTTO
4. DTTO
5. Original entity queried from the database is same as the data I got from the form, even though there is no intermediate persisting, and no variable overwrite done. No comparison is therefore possible, and I can only add new EventUsers, never remove them.

## EventUser collection dumped throughout the process
As you can see, collection freshly fetched from the database contains the same EventUsers as the one I got from the form.

![EventUsers in different stages](https://github.com/machacjan/dto/blob/master/screen.png)
