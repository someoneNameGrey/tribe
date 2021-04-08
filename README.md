## Solution built by Laravel

### Requests

#### Fetch Data
GET: `/api/fetch`

#### Posts Index
GET: `/api/posts`

#### Filter Comments
GET: `/api/comments`

Filter params available: 
- `id`
- `postId` or `post_id`
- `name`
- `email`
- `body`

Example: `/api/comments?email=Eliseo@gardner.biz`