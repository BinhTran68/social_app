export const formatDate = (value, formatting = { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric' }) => {
    if (!value) return value
    return new Date(value).toLocaleDateString(
        'vi-VN',
        formatting
    )
}
