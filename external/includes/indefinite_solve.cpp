/*
 * Academic License - for use in teaching, academic research, and meeting
 * course requirements at degree granting institutions only.  Not for
 * government, commercial, or other organizational use.
 *
 * indefinite_solve.cpp
 *
 * Code generation for function 'indefinite_solve'
 *
 */

/* Include files */
#include <math.h>
#include "rt_nonfinite.h"
#include "indefinite_solve.h"
#include "indefinite_solve_emxutil.h"
#include "ifWhileCond.h"
#include "svd.h"
#include "mldivide.h"

/* Function Definitions */
void indefinite_solve(const emxArray_real_T *aeq, const double beq[3], const
                      emxArray_real_T *lb, emxArray_real_T *answer)
{
  emxArray_real_T *r0;
  int k;
  int loop_ub;
  emxArray_boolean_T *b_answer;
  emxArray_real_T *Z;
  int nx;
  boolean_T p;
  emxArray_real_T *b_Z;
  double unusedU0_data[9];
  int unusedU0_size[2];
  double s_data[3];
  int s_size[1];
  int ns;
  int r;
  double absxk;
  int exponent;
  emxArray_real_T *varargin_1;
  boolean_T exitg1;
  int exitg3;
  int exitg2;
  double i;
  emxInit_real_T1(&r0, 1);
  mldivide(aeq, beq, r0);
  k = answer->size[0] * answer->size[1];
  answer->size[0] = 1;
  answer->size[1] = r0->size[0];
  emxEnsureCapacity_real_T(answer, k);
  loop_ub = r0->size[0];
  for (k = 0; k < loop_ub; k++) {
    answer->data[answer->size[0] * k] = r0->data[k];
  }

  emxFree_real_T(&r0);
  emxInit_boolean_T(&b_answer, 2);
  k = b_answer->size[0] * b_answer->size[1];
  b_answer->size[0] = 1;
  b_answer->size[1] = answer->size[1];
  emxEnsureCapacity_boolean_T(b_answer, k);
  loop_ub = answer->size[0] * answer->size[1];
  for (k = 0; k < loop_ub; k++) {
    b_answer->data[k] = (answer->data[k] > lb->data[k]);
  }

  if (!ifWhileCond(b_answer)) {
    emxInit_real_T(&Z, 2);
    nx = 3 * aeq->size[1];
    p = true;
    for (k = 0; k < nx; k++) {
      if (p && ((!rtIsInf(aeq->data[k])) && (!rtIsNaN(aeq->data[k])))) {
        p = true;
      } else {
        p = false;
      }
    }

    emxInit_real_T(&b_Z, 2);
    if (!p) {
      k = Z->size[0] * Z->size[1];
      Z->size[0] = aeq->size[1];
      Z->size[1] = aeq->size[1];
      emxEnsureCapacity_real_T(Z, k);
      loop_ub = aeq->size[1] * aeq->size[1];
      for (k = 0; k < loop_ub; k++) {
        Z->data[k] = rtNaN;
      }
    } else {
      svd(aeq, unusedU0_data, unusedU0_size, s_data, s_size, b_Z);
      if (3 < aeq->size[1]) {
        ns = 3;
        nx = aeq->size[1];
      } else {
        ns = aeq->size[1];
        nx = 3;
      }

      r = 1;
      if (ns > 0) {
        absxk = fabs(s_data[0]);
        if ((!rtIsInf(absxk)) && (!rtIsNaN(absxk))) {
          if (absxk <= 2.2250738585072014E-308) {
            absxk = 4.94065645841247E-324;
          } else {
            frexp(absxk, &exponent);
            absxk = ldexp(1.0, exponent - 53);
          }
        } else {
          absxk = rtNaN;
        }

        absxk *= (double)nx;
        for (k = 0; k < ns; k++) {
          r += (s_data[k] > absxk);
        }
      }

      if (r > aeq->size[1]) {
        k = 0;
        nx = 0;
      } else {
        k = r - 1;
        nx = aeq->size[1];
      }

      loop_ub = b_Z->size[0];
      ns = Z->size[0] * Z->size[1];
      Z->size[0] = loop_ub;
      Z->size[1] = nx - k;
      emxEnsureCapacity_real_T(Z, ns);
      r = nx - k;
      for (nx = 0; nx < r; nx++) {
        for (ns = 0; ns < loop_ub; ns++) {
          Z->data[ns + Z->size[0] * nx] = b_Z->data[ns + b_Z->size[0] * (k + nx)];
        }
      }
    }

    k = b_Z->size[0] * b_Z->size[1];
    b_Z->size[0] = Z->size[1];
    b_Z->size[1] = Z->size[0];
    emxEnsureCapacity_real_T(b_Z, k);
    loop_ub = Z->size[0];
    for (k = 0; k < loop_ub; k++) {
      r = Z->size[1];
      for (nx = 0; nx < r; nx++) {
        b_Z->data[nx + b_Z->size[0] * k] = Z->data[k + Z->size[0] * nx];
      }
    }

    emxFree_real_T(&Z);
    emxInit_real_T(&varargin_1, 2);
    r = b_Z->size[0];
    k = varargin_1->size[0] * varargin_1->size[1];
    varargin_1->size[0] = 1;
    varargin_1->size[1] = lb->size[1];
    emxEnsureCapacity_real_T(varargin_1, k);
    loop_ub = lb->size[0] * lb->size[1];
    for (k = 0; k < loop_ub; k++) {
      varargin_1->data[k] = lb->data[k] - answer->data[k];
    }

    if (varargin_1->size[1] <= 2) {
      if (varargin_1->size[1] == 1) {
        absxk = varargin_1->data[0];
      } else if ((varargin_1->data[0] < varargin_1->data[1]) || (rtIsNaN
                  (varargin_1->data[0]) && (!rtIsNaN(varargin_1->data[1])))) {
        absxk = varargin_1->data[1];
      } else {
        absxk = varargin_1->data[0];
      }
    } else {
      if (!rtIsNaN(varargin_1->data[0])) {
        nx = 1;
      } else {
        nx = 0;
        k = 2;
        exitg1 = false;
        while ((!exitg1) && (k <= varargin_1->size[1])) {
          if (!rtIsNaN(varargin_1->data[k - 1])) {
            nx = k;
            exitg1 = true;
          } else {
            k++;
          }
        }
      }

      if (nx == 0) {
        absxk = varargin_1->data[0];
      } else {
        absxk = varargin_1->data[nx - 1];
        while (nx + 1 <= varargin_1->size[1]) {
          if (absxk < varargin_1->data[nx]) {
            absxk = varargin_1->data[nx];
          }

          nx++;
        }
      }
    }

    emxFree_real_T(&varargin_1);
    nx = 0;
    do {
      exitg3 = 0;
      if (nx <= r - 1) {
        ns = 0;
        do {
          exitg2 = 0;
          if (ns <= (int)(absxk + 1.0) - 1) {
            loop_ub = answer->size[0] * answer->size[1] - 1;
            k = answer->size[0] * answer->size[1];
            answer->size[0] = 1;
            emxEnsureCapacity_real_T(answer, k);
            i = (double)ns * b_Z->data[nx];
            for (k = 0; k <= loop_ub; k++) {
              answer->data[k] += i;
            }

            k = b_answer->size[0] * b_answer->size[1];
            b_answer->size[0] = 1;
            b_answer->size[1] = answer->size[1];
            emxEnsureCapacity_boolean_T(b_answer, k);
            loop_ub = answer->size[0] * answer->size[1];
            for (k = 0; k < loop_ub; k++) {
              b_answer->data[k] = (answer->data[k] > lb->data[k]);
            }

            if (ifWhileCond(b_answer)) {
              exitg2 = 1;
            } else {
              ns++;
            }
          } else {
            nx++;
            exitg2 = 2;
          }
        } while (exitg2 == 0);

        if (exitg2 == 1) {
          exitg3 = 1;
        }
      } else {
        k = answer->size[0] * answer->size[1];
        answer->size[0] = 1;
        answer->size[1] = 1;
        emxEnsureCapacity_real_T(answer, k);
        answer->data[0] = -1.0;
        exitg3 = 1;
      }
    } while (exitg3 == 0);

    emxFree_real_T(&b_Z);
  }

  emxFree_boolean_T(&b_answer);
}

/* End of code generation (indefinite_solve.cpp) */
