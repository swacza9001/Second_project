<?php

class SongController extends Controller {

    public function process(array $parameters): void {
        $songsManager = new SongsManager();
        $chords = $songsManager->getChords();
        $this->data['chords'] = $chords;
        
        $userManager = new UserManager();
        $user = $userManager->getUser();
        $this->data['admin'] = $user && $user['admin'];
        
        if(!empty($parameters[1]) && $parameters[1] == 'delete') {
            $this->verifyUser(true);
            $songsManager->deleteSong($parameters[0]);
            $this->addMessage('warning', 'Písnička byla odstraněna.');
            $this->reroute('song');
        } else if (!empty($parameters[0])) {
            $song = $songsManager->getSong($parameters[0]);
            $songsChordsPath = $songsManager->getSongsChordsPath($parameters[0]);
            if (!$song)
                $this->reroute('chyba');

            $this->header = array(
                "title" => $song['artist'] . " - " . $song['title'],
                "keywords" => "song, chords",
                "description" => "Song with chords",
            );

            $this->data['artist'] = $song['artist'];
            $this->data['title'] = $song['title'];
            $this->data['strumming_pattern'] = $song['strumming_pattern'];
            $this->data['lyrics'] = $song['lyrics'];
            $this->data['songsChordsPath'] = $songsChordsPath;

            $this->view = 'song';
        } else {
            if ($_POST) {
                $chordNames = array();
                foreach ($_POST as $chord) {
                    $chordNames[] = $chord;
                }
                $songs = $songsManager->getSongsByChords($chordNames);
                $this->data['songs'] = $songs;
                $this->view = 'songs';
            } else {
                $songs = $songsManager->getSongs();
                $this->data['songs'] = $songs;
                $this->view = 'songs';
            }
        }
    }

}
