# IRL.Monster Website

## Will stream key intake (temporary)

- Set environment variable `WILL_TOKEN` on the web server process.
- Share link: `/clients/will/?t=<WILL_TOKEN>`.
- Form POSTs to `/api/will/streamkey.php` and writes the submitted key to `.secrets/will_stream_key.txt`.
- After Ethan manually picks up the key, delete `.secrets/will_stream_key.txt`.
