const enforceMinDigits = (value: number, minDigits: number) => {
    if (value < 10 ** (minDigits - 1)) {
        return `0${value}`;
    }
    return value;
};

export const formatDate = (stringDate: string | Date, type: 'FULL' | 'DATE' | 'HOUR') => {
    const date: Date = typeof stringDate === 'string' ? new Date(stringDate) : stringDate;

    const datePart = `${enforceMinDigits(date.getDate(), 2)}/${enforceMinDigits(date.getMonth() + 1, 2)}/${date.getFullYear()}`;
    const hourPart = `${enforceMinDigits(date.getHours(), 2)}:${enforceMinDigits(date.getMinutes(), 2)}`;

    switch (type) {
        case 'FULL':
            return `${datePart}, às ${hourPart}`;
        case 'DATE':
            return datePart;
        case 'HOUR':
            return hourPart;
        default:
            return date.toString();
    }
};

export const convertFormatedToNormal = (stringDate: string) => {
    const [day, month, year, hour, minute] = [
        stringDate.slice(0, 2),
        stringDate.slice(3, 5),
        stringDate.slice(6, 10),
        stringDate.slice(11, 13),
        stringDate.slice(14, 16),
    ];

    const date = `${year}-${month}-${day}T${hour}:${minute}-03:00`;

    return date;
};