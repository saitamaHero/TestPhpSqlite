CREATE TABLE Notes
(
    _id             INTEGER  PRIMARY KEY,
    _note_title     TEXT NOT NULL DEFAULT '',
    _note_message   TEXT NOT NULL DEFAULT ''
);

CREATE TABLE Tags
(
    _tag_name TEXT UNIQUE NOT NULL
);

CREATE TABLE NoteTags
(
    _note_id INTEGER  NOT NULL,
    _tag     TEXT NOT NULL,
    FOREIGN KEY (_note_id) REFERENCES Notes (_id) ON DELETE CASCADE,
    FOREIGN KEY (_tag)     REFERENCES Tags  (_tag_name)
);

CREATE TABLE UserPreferences
(
    _preference_id      TEXT NOT NULL PRIMARY KEY,
    _preference_value   TEXT NOT NULL
)