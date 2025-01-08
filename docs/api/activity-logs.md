# Activity Logs API Documentation

## List Activity Logs

Get a paginated list of activity logs.

```http
GET /api/activity-logs
```

### Query Parameters

| Parameter  | Type     | Description                                                |
|------------|----------|------------------------------------------------------------|
| search     | string   | Search in description, type, and IP address                |
| type       | string   | Filter by activity type                                    |
| user       | integer  | Filter by user ID                                          |
| from_date  | date     | Filter logs from this date (format: YYYY-MM-DD)           |
| to_date    | date     | Filter logs to this date (format: YYYY-MM-DD)             |
| page       | integer  | Page number for pagination                                 |
| per_page   | integer  | Number of items per page (default: 20)                    |

### Response

```json
{
  "data": [
    {
      "id": 1,
      "type": {
        "text": "Login",
        "color": "success"
      },
      "description": "User logged in",
      "user": {
        "name": "John Doe",
        "email": "john@example.com",
        "avatar": null
      },
      "ip_address": "192.168.1.1",
      "user_agent": "Mozilla/5.0",
      "metadata": null,
      "created_at": "2024-01-07T12:00:00.000000Z",
      "time_ago": "2 hours ago"
    }
  ],
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 10,
    "links": [],
    "path": "/api/activity-logs",
    "per_page": 20,
    "to": 20,
    "total": 200
  }
}
```

## Export Activity Logs

Start an export job for activity logs.

```http
POST /api/activity-logs/export
```

### Request Body

| Parameter  | Type     | Description                                                |
|------------|----------|------------------------------------------------------------|
| search     | string   | Search in description, type, and IP address                |
| type       | string   | Filter by activity type                                    |
| user       | integer  | Filter by user ID                                          |
| from_date  | date     | Filter logs from this date (format: YYYY-MM-DD)           |
| to_date    | date     | Filter logs to this date (format: YYYY-MM-DD)             |

### Response

```json
{
  "message": "Export started. You will be notified when it is completed."
}
```

## Cleanup Activity Logs

Delete old activity logs.

```http
POST /api/activity-logs/cleanup
```

### Response

```json
{
  "message": "100 activity logs have been cleaned up."
}
```

## Get Activity Log Statistics

Get statistics about activity logs.

```http
GET /api/activity-logs/stats
```

### Response

```json
{
  "total": 1000,
  "today": 50,
  "this_week": 300,
  "this_month": 800,
  "by_type": {
    "login": 200,
    "logout": 180,
    "model_created": 300,
    "model_updated": 250,
    "model_deleted": 70
  }
}
```