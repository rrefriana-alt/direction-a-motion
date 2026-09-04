import pathlib
for p in pathlib.Path('resources/views').rglob('*.blade.php'):
    t = p.read_text(encoding='utf-8')
    if '$feat->id * 7 + 1' in t:
        t = t.replace('$feat->id * 7 + 1', 'crc32($feat->id)')
        p.write_text(t, encoding='utf-8')
        print(f'fixed {p}')
