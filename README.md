<p align="center"><a href="https://github.com/AltopsIDN/Notepad" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About MyNotepad

MyNotepad is a web-based note-taking application designed with a clean grid layout and integrated with an advanced responsive sidebar system. This application provides a fluid interface optimized for all device sizes, featuring real-time state management, secure note segregation, and persistent navigation states.

MyNotepad simplifies personal task organization and note management through several core features:

- **Smart Sidebar:** Automatically switches between expanded (240px) and collapsed (64px) modes on desktop, with an independent drawer layout for mobile views.
- **State Persistence:** Sidebar configuration states are stored locally within the browser to eliminate layout jumping during page reloads.
- **Adaptive Grid Layout:** A fluid grid architecture that adjusts automatically from 1 column on mobile viewports up to 4 columns on wide displays.
- **Prioritized Content Streams:** Dedicated structural components to isolate pinned notes from standard regular notes.
- **Dynamic Tag Classification:** Categorization mechanics mapping notes to standardized label elements including Personal, Work, Idea, Important, and Study.
- **Optimized Live Search:** Asynchronous query filtering handled via server-side lazy debouncing to update content without full page reloads.

## Technical Stack

MyNotepad is built upon a modern full-stack ecosystem to ensure reliability, maintainability, and rapid development cycles:

- **Core Framework:** [Laravel](https://laravel.com) handles the backend architecture, routing, and persistent storage.
- **Frontend Interactivity:** [Livewire 3](https://livewire.laravel.com) enables reactive data syncing and CRUD state management without page refreshes.
- **Client Side State:** [Alpine.js](https://alpinejs.dev) controls localized interface components such as tooltips and mobile drawer transitions.
- **Utility Styling Engine:** [TailwindCSS](https://tailwindcss.com) provides systemic fluid breakpoints and custom layout configurations.
- **Icon Resources:** [FontAwesome 6](https://fontawesome.com) delivers clear and semantic visual indicators throughout the navigation layout.

## Database Schema Model

The data layer relies on standard relational structures managed through Laravel Eloquent:

### Notes Table
- `id` (BigInteger, Primary Key)
- `user_id` (BigInteger, Foreign Key linked to users)
- `title` (String, Nullable)
- `body` (Text)
- `is_pinned` (Boolean, Default: false)
- `is_favorite` (Boolean, Default: false)
- `tag` (String, Nullable)
- `deleted_at` (Timestamp, SoftDeletes tracking for Trash)
- `created_at` / `updated_at` (Timestamps)

## Accessibility and Standards

To ensure software accessibility, the application adheres to standard frontend practices:

- Implements structured `aria-label` tags on interactive button controls for screen reader compatibility.
- Outfitted with comprehensive `x-transition` duration curves to avoid abrupt structural layout shifting.
- Utilizes global keyboard event listeners to enable standard hardware dismissal of active mobile navigation elements.
- Implements appropriate `type="button"` attributes on non-submitting elements to prevent accidental form triggers.

## License

MyNotepad is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).