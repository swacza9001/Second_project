<?php

class SongsManager {
    /**
     * vrácení jedné písničky
     * @param string $url 
     * @return array
     */
    public function getSong(string $url): array {
        return Db::queryOne('SELECT song_id, strumming_pattern, artist, title, lyrics, url '
                        . 'FROM songs '
                        . 'WHERE url = ?',
                        array($url));
    }
    /**
     * vrácení všech písniček
     * @return array
     */
    public function getSongs(): array {
        return Db::queryAll('SELECT song_id, url, artist, title '
                        . 'FROM songs '
                        . 'ORDER BY artist');
    }
    /**
     * vrácení jedné písničky podle zvolených akordů
     * @param array $chordNames
     * @return array
     */
    public function getSongsByChords(array $chordNames): array {
        return Db::fetchAssociated('SELECT songs.song_id, songs.url, songs.artist, songs.title '
                        .  'FROM songs '
                        .  'JOIN chord_song ON songs.song_id = chord_song.song_id '
                        .  'JOIN chords ON chord_song.chord_id = chords.chord_id '
                        .  'WHERE chords.chord_name IN (\'' . (implode("', '", $chordNames)) . '\')
                            GROUP BY songs.song_id, songs.url, songs.artist, songs.title '
                        .  'HAVING COUNT(DISTINCT chords.chord_id) = ' . count($chordNames));
    }
    /**
     * vložení písničky
     * @param array $songParameters data písničky
     * @return type
     */
    public function insertSong(array $songParameters) {
        return Db::query('INSERT INTO songs (artist, title, lyrics, url, strumming_pattern) '
                        . 'VALUES(?, ?, ?, ?, ?)',
                        array_values($songParameters));
    }
    /**
     * vložení do vazební tabulky
     * @param array $songsChords
     */
    public function insertChords(array $songsChords) {
        $lastId = Db::lastId();
        foreach ($songsChords as $chord) {
            Db::query('INSERT INTO chord_song (chord_id, song_id) '
                    . 'VALUES (' . $chord . ', ' . $lastId . ')');
        }
    }
    /**
     * vrácení akordů k zobrazení
     * @return array
     */
    public function getChords(): array {
        return Db::fetchColumn('SELECT chord_name '
                        . 'FROM chords '
                        . 'ORDER BY chord_name');
    }
    /**
     * vrácení akordů dané písničky
     * @param type $url
     * @return array
     */
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
    /**
     * vrácení cesty k obrázkům akordů
     * @param type $url
     * @return array
     */
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
    /**
     * úprava písničky
     * @param int $id ID písničky
     * @param array $songParameters data ke změně
     * @return void
     */
    public function updateSong(int $id, array $songParameters): void {
        Db::update('songs', $songParameters, 'WHERE songs.song_id = ?', array($id));
    }
    /**
     * smazání písničky
     * @param type $url
     */
    public function deleteSong($url) {
        Db::query('DELETE FROM songs WHERE url = ?', array($url));
    }

}

