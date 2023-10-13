<?php

class SongsManager {

    public function getSong(string $url): array {
        return Db::queryOne('SELECT song_id, strumming_pattern, artist, title, lyrics, url '
                        . 'FROM songs '
                        . 'WHERE url = ?',
                        array($url));
    }

    public function getSongs(): array {
        return Db::queryAll('SELECT song_id, url, artist, title '
                        . 'FROM songs '
                        . 'ORDER BY artist');
    }

    public function getSongsByChords(array $chordNames): array {
        return Db::fetchAssociated('SELECT songs.song_id, songs.url, songs.artist, songs.title '
                        .  'FROM songs '
                        .  'JOIN chord_song ON songs.song_id = chord_song.song_id '
                        .  'JOIN chords ON chord_song.chord_id = chords.chord_id '
                        .  'WHERE chords.chord_name IN (\'' . (implode("', '", $chordNames)) . '\')
                            GROUP BY songs.song_id, songs.url, songs.artist, songs.title '
                        .  'HAVING COUNT(DISTINCT chords.chord_id) = ' . count($chordNames));
    }

    public function insertSong(array $songParameters) {
        return Db::query('INSERT INTO songs (artist, title, lyrics, url, strumming_pattern) '
                        . 'VALUES(?, ?, ?, ?, ?)',
                        array_values($songParameters));
    }

    public function insertChords(array $songsChords) {
        $lastId = Db::lastId();
        foreach ($songsChords as $chord) {
            Db::query('INSERT INTO chord_song (chord_id, song_id) '
                    . 'VALUES (' . $chord . ', ' . $lastId . ')');
        }
    }

    public function getChords(): array {
        return Db::fetchColumn('SELECT chord_name '
                        . 'FROM chords '
                        . 'ORDER BY chord_name');
    }

    public function getSongsChords($url): array {
        return Db::fetchColumn('SELECT chord_image_path'
                        . 'FROM chords '
                        . 'WHERE chords.chord_id = '
                        . '(SELECT chord_song.chord_id '
                        . 'FROM chord_song'
                        . 'WHERE chord_song.song_id = '
                        . '(SELECT songs.song_id'
                        . 'FROM songs'
                        . 'WHERE url = ' . $url);
    }

    public function getSongsChordsPath($url): array {
        return Db::fetchColumn('SELECT chords.chord_image_path '
                        . 'FROM chords '
                        . 'WHERE chords.chord_id IN ('
                        . 'SELECT chord_song.chord_id '
                        . 'FROM chord_song '
                        . 'WHERE chord_song.song_id = ('
                        . 'SELECT songs.song_id '
                        . 'FROM songs '
                        . 'WHERE songs.url = :url'
                        . ')'
                        . ')',
                        ['url' => $url]
        );
    }
    
    public function updateSong(int $id, array $songParameters): void {
        Db::update('songs', $songParameters, 'WHERE songs.song_id = ?', array($id));
    }
    
    public function deleteSong($url) {
        Db::query('DELETE FROM songs WHERE url = ?', array($url));
    }

}

/**
 * Implement the form for chord entry, song list view, one song view, alter SongController
 */