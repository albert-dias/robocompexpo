import request from "../../util/request";
import { createStateLink } from "@hookstate/core";

const plansRef = createStateLink([]);

const fetchPlans = async (userType) => {
    const plans = plansRef.get()
};