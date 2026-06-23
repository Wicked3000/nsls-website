import asyncio
from playwright.async_api import async_playwright
import os

async def capture_screenshots():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await browser.new_page()

        pages = [
            ("index.html", "home_page.png"),
            ("accomm_rooms.html", "accommodation_page.png"),
            ("restaurant.html", "dining_page.png"),
            ("business.html", "business_page.png"),
            ("staynplay.html", "staynplay_page.png"),
            ("reservations.html", "reservations_page.png"),
            ("contact.html", "contact_page.png")
        ]

        # Start a simple server in a separate process or just use file path
        # Using file path for simplicity as it's static HTML
        base_path = os.path.abspath(".")

        for file_name, screenshot_name in pages:
            url = f"file://{base_path}/{file_name}"
            await page.goto(url)
            await page.wait_for_timeout(1000) # Wait for animations/loads
            await page.screenshot(path=screenshot_name, full_page=True)
            print(f"Captured {screenshot_name}")

        await browser.close()

if __name__ == "__main__":
    asyncio.run(capture_screenshots())
