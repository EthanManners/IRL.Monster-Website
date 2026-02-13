# IRL.Monster Website

## Will stream key intake (temporary)

- URL to send Will: `/clients/will/`.
- Optional token gate: if `WILL_TOKEN` is set on the web process, use `/clients/will/?t=<WILL_TOKEN>`.
- Form POSTs to `/api/will/streamkey.php` and writes the submitted key to `/var/lib/irlmonster-secrets/will_stream_key.txt`.
- Fallback path if `/var/lib/irlmonster-secrets` is not writable: `<repo_root>/.secrets/will_stream_key.txt`.
- Ethan will manually retrieve the key and delete the key file after use.
