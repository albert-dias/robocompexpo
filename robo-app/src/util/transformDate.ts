const transformDate = (date: string) => {
    const day = date.slice(0,2);
    const month = date.slice(3,5);
    const year = date.slice(6);

    return `${year}-${month}-${day}`;
};

export default transformDate;