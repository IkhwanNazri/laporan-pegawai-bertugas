export const formatTarikh = (d) => (d ? new Date(d).toLocaleDateString('ms-MY', { day: '2-digit', month: '2-digit', year: 'numeric' }) : '-')

export const ringkas = (text, max = 60) => {
    const t = text || 'Tiada ulasan'
    return t.length > max ? t.slice(0, max) + '...' : t
}
