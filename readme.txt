Example application.

Purpose of this application is to find available time slots for an event for specific people.
Result is sorted by the amount of attendees that can participate in a meeting.

This solution is very naive. It can be improved in a following ways:
- move date calculations to, for example database - postgresql has great support for both time
  zones and range data types with indexes.
- availability calculations should be done in data retrieval layer.
- add real calendar. Currently schedule handles only one day,
- add time zones, store all time/date information in UTC,
- flexible meeting start, end and duration. Currently only 1 hour meetings starting on an hour,

Usage:
generator.php generates example calendar and stores it in a file.
list.php list available time slots for a meeting for a list of persons (by person id).
