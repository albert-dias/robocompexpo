// Import de pacotes
import { createStateLink, useStateLinkUnmounted } from "@hookstate/core";
// Import de páginas
import request from "../../util/request";
import Request from "../../interfaces/Request";

interface OC {
    id: number;
    quantity_garbage_bags: number;
    date_service_ordes: string;
    address: string;
    number: string;
    complement: string;
    comments: string;
    status: string;
    district: string;
    city: string;
    state: string;
    created: string;
    period: string;
}

const scheduledRef = createStateLink<OC[] | undefined>(undefined);
const finalizedRef = createStateLink<OC[] | undefined>(undefined);
const canceledRef = createStateLink<OC[] | undefined>(undefined);
const loadingScheduledRef = createStateLink(true);
const loadingFinalizedRef = createStateLink(true);
const loadingCanceledRef = createStateLink(true);

const fetch = async (type: 'scheduled' | 'finalized' | 'canceled') => {
    const loadingScheduled = loadingScheduledRef.access();
    const loadingFinalized = loadingFinalizedRef.access();
    const loadingCanceled = loadingCanceledRef.access();

    if (type === 'scheduled') {
        loadingScheduled.set(true);
        const response = await request.authPost<Request<OC[]>>(
            'CollectionOrders/listOsScheduledClient/pendente',
        );
        loadingScheduled.set(false);
        response.status === true && scheduledRef.access().set(response.result);
    } else if (type === 'finalized') {
        loadingFinalized.set(true);
        const response = await request.authPost<Request<OC[]>>(
            'CollectionOrders/listOsScheduledClient/finalizada',
        );
        loadingFinalized.set(false);
        response.status === true && finalizedRef.access().set(response.result);
    } else if (type == 'canceled') {
        loadingCanceled.set(true);
        const response = await request.authPost<Request<OC[]>>(
            'CollectionOrders/listOsScheduledClient/cancelada',
        );
        loadingCanceled.set(false);
        response.status === true && canceledRef.access().set(response.result);
    }
};

export default {
    scheduledRef,
    finalizedRef,
    canceledRef,
    fetch,
    loadingScheduledRef,
    loadingFinalizedRef,
    loadingCanceledRef,
};