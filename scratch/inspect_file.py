with open(r'c:\xampp\htdocs\Basirah\resources\views\consultations\index.blade.php', 'rb') as f:
    content = f.read()
    # Find the :root section
    start = content.find(b':root {')
    if start != -1:
        end = content.find(b'}', start)
        print(f"Hex of :root section:\n{content[start:end+1].hex()}")
        print(f"Raw of :root section:\n{content[start:end+1]}")
    else:
        print("Could not find :root section")
