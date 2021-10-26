import { createStateLink, useStateLinkUnmounted } from "@hookstate/core";
import request from "../../util/request";

type Category = {
    id: 'default' | number;
    name: string;
    description_category?: string;
    url_icon?: string;
    children?: Array<{
        id: 'default' | number;
        name: string;
    }>
    subCategoryLoading?: boolean;
};

const defaultCategory = {
    id: 'default',
    name: 'Selecionar...',
    subCategoryLoading: false,
    children: [],
} as Category;

const categoriesRef = createStateLink<Category[] | undefined>(undefined);
let loading = true;

const categories = useStateLinkUnmounted(categoriesRef);

interface RequestCategory {
    result: Category[];
}

type RequestSubcategory = {
    result: {
        [s: string]: string;
    };
}

const fetchCategories = async () => {
    if (loading === false) {
        return;
    }

    const { result } = await request.get<RequestCategory>('categories/getAll');
    const constructedCategories: Category[] = [defaultCategory, ...result];
    categories.set(constructedCategories);
    loading = false;
};

const fetchSubcategory = async (category_id: 'default' | number) => {
    if (category_id === 'default' || !categories.value) {
        return;
    }

    const fCategory = categories.value.find((i) => i.id === category_id);
    if (!fCategory || fCategory.children) {
        return;
    }

    categories.set((prev) => {
        if (!prev) { return undefined; }
        const foundCategory = prev.find((i) => i.id === fCategory.id);
        if (!foundCategory) {
            return prev;
        }

        foundCategory.subCategoryLoading = true;

        return prev;
    });

    const { result } = await request.post<RequestSubcategory>('subcategories/getCategoriesId', {
        category_id: category_id.toString(),
    });

    categories.set((prev) => {
        if (!prev) { return undefined; }
        const foundCategory = prev.find((i) => i.id === fCategory.id);
        if (!foundCategory) {
            return prev;
        }

        const subCategories: Required<Category>['children'] = [{
            id: 'default',
            name: 'Selecionar...',
        }];

        Object.keys(result).forEach((i) => {
            const num = Number(i);
            if (Number.isNaN(num)) {
                return;
            }

            subCategories.push({
                id: num,
                name: result[i],
            });
        });

        foundCategory.subCategoryLoading = false;
        foundCategory.children = subCategories;

        return prev;
    });
};

export default {
    categoriesRef,
    fetchCategories,
    fetchSubcategory,
};
