# avodatracker
Track your efforts and your progress in Avodas Hashem

Implementatiom will be phased so as not to drown in scope creep.


Most basic implementation will require users, tasks, and successes (indications that a task has been fulfilled.)
The UI would upon login, display the lists of tasks (with CRUD capability) and a streak - the number of uninterrupted successes, calculated weekly,daily,or mothly, as a task requires. (Non scheduled tasks can possibly also include 'failures' so that streaks can be calculated,

Future enhancement can include
- Badges for various acheivements (A cool idea might be a physical chip with a QR code to prove it is still valid for 30-day streaks, 6-month streaks, etc)
- UI for more sophisticated success metrics (see schema) 
- Task Analytics, going beyond streaks to show percentages, patterns of when failure happens etc
- prepared tasks from which to choose, perhaps grouped together (sequentially or non) by overarching goal. Sets and subsets.
- Tips, tricks, and tutorials on tasks and sets.
- Inter-user links such as Chavrusas and groups. Functionality to make these connections.
- limitations such as only one active "new" task at a time from each category (Sur MeiRa, Asei Toiv, Bakesh Shalom/work with others, AND/OR Torah/Tefillah/Tzedaka). Tasks which meet a criteria of a certain duration of consistency etc are considered completed and can continue to be tracked without taking up an "active" slot.
- Initial Status, tasks that are already acheived at sign up, such as Chitas for someone who already does it, which would not count toward active slots.
- Group Medals indicated participation in a group who has acheived a certain status - Chitas Group, 3 Prakim Group, Smartphone-free Group.
- A Mashpia user who can oversee and perhaps override or add limitations to the user
- Printed notebooks generator (once this thing has more form) for offline use

________________________________________________________________

Initial Deliverables

- DB Schema
- Functional Code
- Responsive Cool Design
