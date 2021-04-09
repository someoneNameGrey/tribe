## Solution built by Laravel

### Requests

#### Fetch Data (Deprecated)
GET: `/api/fetch`

#### Posts Index
GET: `/api/posts`

#### Filter Comments
GET: `/api/comments`

Filter params available: 
- `q`
- `id` (Deprecated)
- `postId` or `post_id` (Deprecated)
- `name` (Deprecated)
- `email` (Deprecated)
- `body` (Deprecated)

Example: `/api/comments?q=laboriosam`