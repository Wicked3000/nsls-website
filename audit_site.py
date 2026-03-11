import os
import glob
from playwright.sync_api import sync_playwright

def audit():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        html_files = glob.glob("*.html")
        results = {}

        for file in html_files:
            print(f"Auditing {file}...")
            url = "file://" + os.path.abspath(file)
            errors = []
            console_msgs = []

            page.on("pageerror", lambda exc: errors.append(str(exc)))
            page.on("console", lambda msg: console_msgs.append(f"{msg.type}: {msg.text}"))

            try:
                response = page.goto(url)
                if response.status != 0 and response.status != 200:
                     errors.append(f"Status code {response.status}")

                # Check for broken images
                broken_images = page.evaluate("""
                    () => {
                        const images = Array.from(document.querySelectorAll('img'));
                        return images.filter(img => !img.complete || img.naturalWidth === 0).map(img => img.src);
                    }
                """)

                # Check for broken links
                links = page.evaluate("""
                    () => {
                        return Array.from(document.querySelectorAll('a')).map(a => a.href);
                    }
                """)

                results[file] = {
                    "errors": errors,
                    "console": console_msgs,
                    "broken_images": broken_images,
                    "links": len(links)
                }
            except Exception as e:
                results[file] = {"error": str(e)}

        browser.close()
        return results

if __name__ == "__main__":
    import json
    res = audit()
    print(json.dumps(res, indent=2))
